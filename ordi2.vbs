Option Explicit
Dim objWMIService, objComputer, colComputer, strComputer
strComputer = inputbox( "Nom du serveur", "Input" )
Set objWMIService = GetObject("winmgmts:" _
& "{impersonationLevel=impersonate}!\\" _
& strComputer & "\root\cimv2")
Set colComputer = objWMIService.ExecQuery _
("Select * from Win32_ComputerSystem")
For Each objComputer in colComputer
WScript.Echo objComputer.Name
Wscript.Echo objComputer.UserName & " is logged on"
Next