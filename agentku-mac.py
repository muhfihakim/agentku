import time
import json
import urllib.request
import os, base64
import sys
import psutil
import socket
import subprocess
from io import BytesIO

try:
    import tkinter as tk
    from tkinter import simpledialog
    HAS_TKINTER = True
except ImportError:
    HAS_TKINTER = False

def get_active_window():
    script = """
    tell application "System Events"
        set frontApp to first application process whose frontmost is true
        set appName to name of frontApp
        try
            set winTitle to name of front window of frontApp
            return appName & " - " & winTitle
        on error
            return appName
        end try
    end tell
    """
    try:
        res = subprocess.run(['osascript', '-e', script], capture_output=True, text=True)
        return res.stdout.strip()
    except Exception:
        return "Unknown"

def get_open_apps():
    script = """
    tell application "System Events"
        set appNames to name of every application process whose background only is false
        return appNames
    end tell
    """
    try:
        res = subprocess.run(['osascript', '-e', script], capture_output=True, text=True)
        apps = res.stdout.strip().split(", ")
        return apps[:10]
    except Exception:
        return []

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
        airport_cmd = "/System/Library/PrivateFrameworks/Apple80211.framework/Resources/airport -I"
        out = subprocess.check_output(airport_cmd, shell=True, text=True)
        for line in out.splitlines():
            if " SSID:" in line:
                ssid = line.split(":", 1)[1].strip()
                break
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

def get_idle_time():
    try:
        out = subprocess.check_output("ioreg -c IOHIDSystem | awk '/HIDIdleTime/ {print int($NF/1000000000); exit}'", shell=True, text=True)
        return float(out.strip())
    except:
        return 0

loc_cache = {"lat": None, "lng": None, "city": "Unknown", "last_update": 0}
def get_location():
    if time.time() - loc_cache["last_update"] < 300: # Cache 5 mins
        return loc_cache["lat"], loc_cache["lng"], loc_cache["city"]
        
    # IP Geolocation Fallback
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
            if '/Volumes/' in p.mountpoint and not p.mountpoint.startswith('/Volumes/Macintosh HD') and not p.mountpoint.startswith('/Volumes/Recovery'):
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
        if HAS_TKINTER:
            root = tk.Tk()
            root.withdraw()
            # Bring to front on Mac
            os.system('''/usr/bin/osascript -e 'tell app "Finder" to set frontmost of process "Python" to true' ''')
            if not tenant:
                t = simpledialog.askstring("AgentKu Setup", "Masukkan Tenant ID:", parent=root)
                if t: config['tenant'] = t
            if not token:
                t = simpledialog.askstring("AgentKu Setup", "Masukkan Device Token (UUID):", parent=root)
                if t: config['device_token'] = t
            root.destroy()
        else:
            if not tenant:
                config['tenant'] = input("AgentKu Setup - Masukkan Tenant ID: ").strip()
            if not token:
                config['device_token'] = input("AgentKu Setup - Masukkan Device Token (UUID): ").strip()
                
        with open("config.json", "w") as f:
            json.dump(config, f)
    except Exception as e:
        pass
    return config

def main():
    print("AgentKu macOS started...")
    url = "https://agentku.mybbs.id/api/monitor"

    import platform
    try:
        cpu_name = subprocess.check_output("sysctl -n machdep.cpu.brand_string", shell=True, text=True).strip()
    except:
        cpu_name = platform.processor()
        
    os_version = f"macOS {platform.mac_ver()[0]}"
    total_ram = f"{round(psutil.virtual_memory().total / (1024**3))} GB"
    
    psutil.cpu_percent(interval=None) # init
    last_net = psutil.net_io_counters()
    last_time = time.time()
    
    app_durations = {}

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
            
        if agent_status == "active" and window and window != "Unknown":
            app_name = window.split(" - ")[0] if " - " in window else window
            app_durations[app_name] = app_durations.get(app_name, 0) + 2
            
        top_apps = [{"name": k, "duration": v} for k, v in sorted(app_durations.items(), key=lambda item: item[1], reverse=True)[:5]]

        cpu = psutil.cpu_percent(interval=None)
        ram = psutil.virtual_memory().percent
        try:
            storage = psutil.disk_usage('/').percent
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
            os.system('screencapture -x -C /tmp/agent_screen.jpg')
            os.system('sips -Z 1280 -s format jpeg -s formatOptions 60 /tmp/agent_screen.jpg > /dev/null 2>&1')
            with open('/tmp/agent_screen.jpg', 'rb') as f:
                screen_b64 = "data:image/jpeg;base64," + base64.b64encode(f.read()).decode('utf-8')
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
                    if HAS_TKINTER:
                        root = tk.Tk()
                        root.withdraw()
                        os.system('''/usr/bin/osascript -e 'tell app "Finder" to set frontmost of process "Python" to true' ''')
                        new_token = simpledialog.askstring("AgentKu", "Device Token is revoked or invalid.\nPlease enter a new Device Token:", parent=root)
                        if new_token:
                            config['device_token'] = new_token
                            with open("config.json", "w") as f:
                                json.dump(config, f)
                        root.destroy()
                    else:
                        new_token = input("AgentKu - Device Token is revoked or invalid. Please enter a new Device Token: ").strip()
                        if new_token:
                            config['device_token'] = new_token
                            with open("config.json", "w") as f:
                                json.dump(config, f)
                except Exception as popup_e:
                    print(f"Prompt error: {popup_e}")
            else:
                print(f"Error sending data HTTP: {e.code}")
        except Exception as e:
            print(f"Error sending data: {e}")
            
        time.sleep(5)

if __name__ == "__main__":
    main()
