import re

def main():
    with open('resources/views/client/detail.blade.php', 'r') as f:
        content = f.read()

    # We want to extract all the cards
    # Pattern: <!-- Card Name --> ... </div> (matching the outer div)
    # Actually, we can just split the file at known points.
    
    # 1. Everything up to the end of Location Map Card
    p1_end = content.find('<!-- Live Activity Timeline Card -->')
    p1 = content[:p1_end]
    
    # We need to close the .detail-screen div here!
    p1 = p1.strip() + "\n            </div>\n"
    
    # 2. Extract detail-info start to Current Activity Card end
    p_info_start = content.find('<!-- Right: Detail Info -->')
    p_info_end = content.find('<!-- Open Apps Card -->')
    
    # Wait, Top Apps, Performance, Network are currently in detail-info BEFORE Current Activity
    # Let's extract them specifically
    
    def extract_block(name, next_name):
        start = content.find(name)
        if start == -1: return ""
        end = content.find(next_name) if next_name else content.find('</section>')
        if end == -1: return ""
        return content[start:end].strip()

    employee_header = extract_block('<!-- Employee Header -->', '<!-- Device Info Card -->')
    device_info = extract_block('<!-- Device Info Card -->', '<!-- Top Apps Duration Card -->')
    current_activity = extract_block('<!-- Current Activity Card -->', '<!-- Open Apps Card -->')
    
    # The right column
    p2 = f"""
            <!-- Right: Detail Info -->
            <div class="detail-info">
                {employee_header}
                
                {device_info}
                
                {current_activity}
            </div>
        </div> <!-- End of detail-layout -->
"""

    # 3. The bottom grid
    timeline = extract_block('<!-- Live Activity Timeline Card -->', '<!-- Historical Screenshots -->')
    screenshots = extract_block('<!-- Historical Screenshots -->', '<!-- Security Alerts -->')
    alerts = extract_block('<!-- Security Alerts -->', '</div>\n\n            <!-- Right: Detail Info -->')
    top_apps = extract_block('<!-- Top Apps Duration Card -->', '<!-- Performance Card -->')
    perf = extract_block('<!-- Performance Card -->', '<!-- Network Traffic Card -->')
    network = extract_block('<!-- Network Traffic Card -->', '<!-- Current Activity Card -->')
    open_apps = extract_block('<!-- Open Apps Card -->', '</div>\n        </div>\n    </section>')
    # Fix alerts end tag which might have an extra </div>
    if alerts.endswith("</div>\n            </div>"):
        alerts = alerts[:-28]
    if open_apps.endswith("</div>\n            </div>"):
         open_apps = open_apps[:-28]

    p3 = f"""
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-top: 24px;">
            {timeline}
            {screenshots}
            {alerts}
            {top_apps}
            {perf}
            {network}
            {open_apps}
        </div>
    </section>
</x-layouts.app>
"""

    new_content = p1 + p2 + p3
    
    with open('resources/views/client/detail.blade.php', 'w') as f:
        f.write(new_content)

if __name__ == '__main__':
    main()
