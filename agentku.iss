[Setup]
AppName=AgentKu
AppVersion=1.0
DefaultDirName={autopf}\AgentKu
DefaultGroupName=AgentKu
OutputDir=dist
OutputBaseFilename=AgentKu_Setup
Compression=lzma
SolidCompression=yes
PrivilegesRequired=lowest

[Files]
Source: "dist\agentku-windows.exe"; DestDir: "{app}"; Flags: ignoreversion

[Icons]
Name: "{group}\AgentKu"; Filename: "{app}\agentku-windows.exe"

[Registry]
Root: HKCU; Subkey: "Software\Microsoft\Windows\CurrentVersion\Run"; ValueType: string; ValueName: "AgentKu"; ValueData: """{app}\agentku-windows.exe"""; Flags: uninsdeletevalue

[Run]
Filename: "{app}\agentku-windows.exe"; Description: "Launch AgentKu Monitor"; Flags: nowait postinstall skipifsilent
