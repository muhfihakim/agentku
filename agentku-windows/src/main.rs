use std::time::Duration;
use std::thread;

fn main() {
    println!("AgentKu LuthfiKim started...");
    
    // Simulate background monitoring loop
    loop {
        println!("Capture screen. Read active window...");
        
        let data = r#"{"status": "active", "window": "Chrome"}"#;
        println!("Send payload: {}", data);
        
        // TODO: Send HTTP POST to Dashboard API
        
        thread::sleep(Duration::from_secs(5));
    }
}
