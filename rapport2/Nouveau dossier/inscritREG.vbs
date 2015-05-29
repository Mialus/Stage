on error resume next
Dim WSHShell, fs
Set WSHShell = WScript.CreateObject("WScript.Shell")

Const OverwriteExisting = True
Set objFSO = CreateObject("Scripting.FileSystemObject")
objFSO.CopyFile "\\sdis25.lan\netlogon\ocx\ocx\WebQuartz.ocx" , "%systemroot%\system32\WebQuartz.ocx", OverwriteExisting

WshShell.run "regedit /s \\sdis25.lan\netlogon\inscription_site_confiance.reg",1,True 
WshShell.run "regedit /s \\sdis25.lan\netlogon\config_sites_confiances.reg",1,True 
WshShell.run "regedit /s \\sdis25.lan\netlogon\horoquartz.reg",1,True


if objFSO.FileExists("C:\Program Files\Microsoft Office\Office12\WINWORD.EXE") then
	WshShell.run "regedit /s \\sdis25.lan\netlogon\outlook12.reg",1,True
end if

Set oShell = CreateObject("Wscript.Shell") 
oShell.Run "RegSvr32 /s " & chr(34) & "%systemroot%\system32\WebQuartz.ocx" & chr(34) 


Wscript.exit
