import time
# Trigger build
import json
import urllib.request
import os, base64
import ctypes
import sys
import psutil
import socket
import subprocess
from PIL import ImageGrab
from io import BytesIO

import tkinter as tk
from tkinter import simpledialog

# Prevent multiple instances
mutex = ctypes.windll.kernel32.CreateMutexW(None, False, "Global\\AgentKu_Monitor_Mutex_v1")
if ctypes.windll.kernel32.GetLastError() == 183: # ERROR_ALREADY_EXISTS
    sys.exit(0)

def get_active_window():
    try:
        hwnd = ctypes.windll.user32.GetForegroundWindow()
        length = ctypes.windll.user32.GetWindowTextLengthW(hwnd)
        buff = ctypes.create_unicode_buffer(length + 1)
        ctypes.windll.user32.GetWindowTextW(hwnd, buff, length + 1)
        return buff.value
    except Exception:
        return "Unknown"

def get_open_apps():
    titles = []
    def foreach_window(hwnd, lParam):
        if ctypes.windll.user32.IsWindowVisible(hwnd):
            length = ctypes.windll.user32.GetWindowTextLengthW(hwnd)
            if length > 0:
                buff = ctypes.create_unicode_buffer(length + 1)
                ctypes.windll.user32.GetWindowTextW(hwnd, buff, length + 1)
                title = buff.value
                if title not in titles and title != "Program Manager" and title != "Settings":
                    titles.append(title)
        return True
    EnumWindowsProc = ctypes.WINFUNCTYPE(ctypes.c_bool, ctypes.POINTER(ctypes.c_int), ctypes.POINTER(ctypes.c_int))
    ctypes.windll.user32.EnumWindows(EnumWindowsProc(foreach_window), 0)
    return titles[:10]

net_cache = {"ip": "127.0.0.1", "ssid": "Unknown", "last_update": 0}
def get_network_info():
    if time.time() - net_cache["last_update"] < 60:
        return net_cache["ip"], net_cache["ssid"]

    ip = "127.0.0.1"
    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        s.connect(("8.8.8.8", 80))
        ip = s.getsockname()[0]
        s.close()
    except Exception:
        pass

    ssid = "Unknown"
    try:
        ps_out = subprocess.check_output(
            'powershell -NoProfile -Command "(Get-NetConnectionProfile).Name"',
            shell=True, text=True, creationflags=0x08000000,
            stdin=subprocess.DEVNULL, stderr=subprocess.DEVNULL
        ).strip()
        if ps_out:
            ssid = ps_out.splitlines()[0]
    except Exception:
        pass

    net_cache["ip"] = ip
    net_cache["ssid"] = ssid
    net_cache["last_update"] = time.time()
    return ip, ssid

def get_battery_info():
    try:
        bat = psutil.sensors_battery()
        if bat:
            return bat.percent, bat.power_plugged
    except:
        pass
    return None, None

class LASTINPUTINFO(ctypes.Structure):
    _fields_ = [("cbSize", ctypes.c_uint), ("dwTime", ctypes.c_uint)]

def get_idle_time():
    lii = LASTINPUTINFO()
    lii.cbSize = ctypes.sizeof(LASTINPUTINFO)
    if ctypes.windll.user32.GetLastInputInfo(ctypes.byref(lii)):
        tick_count = ctypes.windll.kernel32.GetTickCount()
        millis = (tick_count - lii.dwTime) & 0xFFFFFFFF
        return millis / 1000.0
    return 0

loc_cache = {"lat": None, "lng": None, "city": "Unknown", "last_update": 0}
def get_location():
    if time.time() - loc_cache["last_update"] < 300: # Cache 5 mins
        return loc_cache["lat"], loc_cache["lng"], loc_cache["city"]
        
    # Attempt 1: Windows GPS API (GeoCoordinateWatcher)
    try:
        ps_script = """
        Add-Type -AssemblyName System.Device
        $w = New-Object System.Device.Location.GeoCoordinateWatcher
        $w.Start()
        Start-Sleep -Seconds 2
        $loc = $w.Position.Location
        if ($loc.IsUnknown -ne $true) { Write-Output "$($loc.Latitude),$($loc.Longitude)" }
        $w.Stop()
        """
        ps_out = subprocess.check_output(['powershell', '-NoProfile', '-Command', ps_script], creationflags=0x08000000, timeout=4, text=True).strip()
        if ps_out and "," in ps_out:
            lat, lng = ps_out.split(",")
            loc_cache["lat"], loc_cache["lng"], loc_cache["city"] = float(lat), float(lng), "GPS Location"
            loc_cache["last_update"] = time.time()
            return loc_cache["lat"], loc_cache["lng"], loc_cache["city"]
    except:
        pass

    # Attempt 2: IP Geolocation Fallback
    try:
        req = urllib.request.Request("https://ipinfo.io/json")
        with urllib.request.urlopen(req, timeout=3) as res:
            data = json.loads(res.read().decode())
            loc = data.get("loc", "").split(",")
            if len(loc) == 2:
                loc_cache["lat"], loc_cache["lng"] = float(loc[0]), float(loc[1])
                loc_cache["city"] = data.get("city", "Unknown")
    except:
        pass

    loc_cache["last_update"] = time.time()
    return loc_cache["lat"], loc_cache["lng"], loc_cache["city"]

def get_usb_drives():
    drives = []
    try:
        for p in psutil.disk_partitions():
            if 'removable' in p.opts.lower():
                drives.append(p.device)
    except:
        pass
    return drives

def check_and_prompt_config(config):
    tenant = config.get("tenant", "")
    token = config.get("device_token", "")
    if tenant and token:
        return config
    try:
        root = tk.Tk()
        root.withdraw()
        root.attributes('-topmost', True)
        if not tenant:
            t = simpledialog.askstring("AgentKu Setup", "Masukkan Tenant ID:", parent=root)
            if t: config['tenant'] = t
        if not token:
            t = simpledialog.askstring("AgentKu Setup", "Masukkan Device Token (UUID):", parent=root)
            if t: config['device_token'] = t
        with open("config.json", "w") as f:
            json.dump(config, f)
        root.destroy()
    except Exception as e:
        pass
    return config

def add_to_startup():
    try:
        import winreg
        if getattr(sys, 'frozen', False):
            filepath = sys.executable
        else:
            filepath = os.path.abspath(__file__)
        key = winreg.OpenKey(winreg.HKEY_CURRENT_USER, r"Software\Microsoft\Windows\CurrentVersion\Run", 0, winreg.KEY_ALL_ACCESS)
        winreg.SetValueEx(key, "AgentKu", 0, winreg.REG_SZ, f'"{filepath}"')
        winreg.CloseKey(key)
    except Exception as e:
        pass

def main():
    print("AgentKu Windows started...")
    add_to_startup()
    url = "https://agentku.mybbs.id/api/monitor"

    try:
        ctypes.windll.shcore.SetProcessDpiAwareness(2)
    except:
        try:
            ctypes.windll.user32.SetProcessDPIAware()
        except:
            pass

    import platform
    cpu_name = platform.processor()
    try:
        cpu_name = subprocess.check_output('wmic cpu get name', shell=True, text=True, creationflags=0x08000000).split('\n')[1].strip()
    except:
        pass
    os_version = f"{platform.system()} {platform.release()}"
    total_ram = f"{round(psutil.virtual_memory().total / (1024**3))} GB"
    
    psutil.cpu_percent(interval=None) # init
    last_net = psutil.net_io_counters()
    last_time = time.time()
    
    app_durations = {} # To track time spent on apps

    while True:
        window = get_active_window()
        apps = get_open_apps()
        ip, ssid = get_network_info()
        bat_percent, bat_plugged = get_battery_info()
        lat, lng, city = get_location()
        
        system_uptime = time.time() - psutil.boot_time()
        
        idle_seconds = get_idle_time()
        agent_status = "active"
        if idle_seconds > 300: # 5 minutes idle
            agent_status = "idle"
            
        # Track active app duration (if not idle)
        if agent_status == "active" and window and window != "Unknown":
            # Extract basic app name from window title (e.g. "Google Chrome")
            app_name = window.split(" - ")[-1] if " - " in window else window
            app_durations[app_name] = app_durations.get(app_name, 0) + 2
            
        # Sort and get top 5 apps by duration
        top_apps = [{"name": k, "duration": v} for k, v in sorted(app_durations.items(), key=lambda item: item[1], reverse=True)[:5]]

        cpu = psutil.cpu_percent(interval=None)
        ram = psutil.virtual_memory().percent
        try:
            storage = psutil.disk_usage('C:\\').percent
        except:
            storage = 0
            
        current_time = time.time()
        current_net = psutil.net_io_counters()
        time_diff = current_time - last_time
        download_speed = 0
        upload_speed = 0
        if time_diff > 0:
            download_speed = ((current_net.bytes_recv - last_net.bytes_recv) / time_diff) / 1024 # KB/s
            upload_speed = ((current_net.bytes_sent - last_net.bytes_sent) / time_diff) / 1024 # KB/s
        
        last_net = current_net
        last_time = current_time

        screen_b64 = ""
        try:
            img = ImageGrab.grab()
            img = img.convert('RGB')
            img.thumbnail((1280, 720))
            buffered = BytesIO()
            img.save(buffered, format="JPEG", quality=60)
            screen_b64 = "data:image/jpeg;base64," + base64.b64encode(buffered.getvalue()).decode('utf-8')
        except Exception as e:
            pass

        data = {
            "status": agent_status,
            "window": window,
            "user": socket.gethostname(),
            "device": os_version,
            "cpu_name": cpu_name,
            "total_ram": total_ram,
            "uptime": round(system_uptime),
            "screen": screen_b64,
            "cpu": cpu,
            "ram": ram,
            "storage": storage,
            "net_download": round(download_speed, 2),
            "net_upload": round(upload_speed, 2),
            "ip": ip,
            "ssid": ssid,
            "apps": apps,
            "top_apps": top_apps,
            "usb_drives": get_usb_drives(),
            "battery_percent": bat_percent,
            "battery_plugged": bat_plugged,
            "lat": lat,
            "lng": lng,
            "city": city,
            "idle_time": round(idle_seconds)
        }

        # Read config if exists
        config = {}
        try:
            if os.path.exists("config.json"):
                with open("config.json", "r") as f:
                    config = json.load(f)
        except:
            pass
            
        config = check_and_prompt_config(config)
        token = config.get("device_token", "")
        tenant = config.get("tenant", "")
        
        if not token or not tenant:
            time.sleep(5)
            continue
        
        headers = {'Content-Type': 'application/json', 'Accept': 'application/json'}
        if token:
            headers['Authorization'] = f'Bearer {token}'
        if tenant:
            headers['X-Tenant'] = tenant

        req = urllib.request.Request(
            url,
            data=json.dumps(data).encode('utf-8'),
            headers=headers,
            method='POST'
        )

        try:
            import ssl
            ctx = ssl.create_default_context()
            ctx.check_hostname = False
            ctx.verify_mode = ssl.CERT_NONE
            with urllib.request.urlopen(req, context=ctx) as response:
                print(f"Sent: {window} -> {response.status}")
        except urllib.error.HTTPError as e:
            if e.code == 401:
                print("Token revoked. Prompting user...")
                try:
                    root = tk.Tk()
                    root.withdraw()
                    root.attributes('-topmost', True)
                    
                    new_token = simpledialog.askstring("AgentKu", "Device Token is revoked or invalid.\nPlease enter a new Device Token:", parent=root)
                    
                    if new_token:
                        config['device_token'] = new_token
                        with open("config.json", "w") as f:
                            json.dump(config, f)
                    root.destroy()
                except Exception as popup_e:
                    print(f"Popup error: {popup_e}")
            else:
                print(f"Error sending data HTTP: {e.code}")
        except Exception as e:
            print(f"Error sending data: {e}")

        time.sleep(2)

if __name__ == "__main__":
    main()
