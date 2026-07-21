import re

with open('resources/views/client/detail.blade.php', 'r') as f:
    content = f.read()

# Define the markers
blocks = {}
sections = [
    "Location Map Card",
    "Live Activity Timeline Card",
    "Historical Screenshots",
    "Security Alerts",
    "Employee Header",
    "Device Info Card",
    "Top Apps Duration Card",
    "Performance Card",
    "Network Traffic Card",
    "Current Activity Card",
    "Open Apps Card"
]

for i in range(len(sections)):
    start_tag = f"<!-- {sections[i]} -->"
    end_tag = f"<!-- {sections[i+1]} -->" if i < len(sections)-1 else "</div>\n        </div>\n    </section>"
    
    if i == len(sections)-1:
        # Special case for the last one
        match = re.search(f"{start_tag}(.*?)(</div>\s*</div>\s*</section>)", content, re.DOTALL)
        if match:
            blocks[sections[i]] = start_tag + match.group(1)
    else:
        # Try to find the block until the next comment
        # Sometimes there's a </div> separating columns
        match = re.search(f"{start_tag}(.*?)<!--", content, re.DOTALL)
        if match:
            blocks[sections[i]] = start_tag + match.group(1)

# Wait, regex parsing HTML is fragile. Let's just do it manually with multi_replace_file_content but in smaller chunks!
