Option Explicit

Const ADS_SCOPE_SUBTREE = 2
Const ForReading = 1, ForWriting = 2, ForAppending = 8
' Nom du domaine (en .local)
Const domain = "sdis25"

DIM objConnection, objCommand, objFSO, objRecordSet, objF
Dim sortie, sortie2, objWMIService, objComputer, colComputer

' Fichier de sortie
Const sUnc="c:\PCS.csv"

Set objFSO = CreateObject("Scripting.FileSystemObject")
Set objF=objFSO.CreateTextFile(sUnc)
objF.Close

Set objF=objFSO.openTextFile(sUnc,ForWriting)

Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"

Set objCOmmand.ActiveConnection = objConnection
objCommand.CommandText = "Select Name, Location, Distinguishedname from 'LDAP://DC=sdis25,DC=lan' Where objectClass='computer'"
objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE
Set objRecordSet = objCommand.Execute
objRecordSet.MoveFirst

Do Until objRecordSet.EOF
sortie2 = objRecordSet.Fields("Name").Value
sortie = objRecordSet.Fields("Distinguishedname").Value
If (InStr(sortie,"DIR") or InStr(sortie,"GROUPEMENTOUEST") or InStr(sortie,"GROUPEMENTEST") or InStr(sortie,"GROUPEMENTSUD")) THEN


'If (InStr(sortie,"GGOSCESYSINFORMATIONRESEAU")=0) Then
If ping(sortie2)=0 Then
objF.Write(sortie2 &"; En marche ! -> ")
On Error Resume Next
Err.Clear
Set objWMIService = GetObject("winmgmts:" _
& "{impersonationLevel=impersonate}!\\" _
& sortie2 & "\root\cimv2")
Set colComputer = objWMIService.ExecQuery _
("Select * from Win32_ComputerSystem")
If (Err.Number <> 0)Then
For Each objComputer in colComputer
objF.Write("Nobody is logged on")
Next
Else
For Each objComputer in colComputer
objComputer.UserName = objComputer.UserName & "911"
If objComputer.UserName = "911" Then
objF.Write("Nobody is logged on")
Else
objComputer.UserName = Left(objComputer.UserName, Len(objComputer.UserName)-3)
objF.Write(objComputer.UserName & " is logged on")
End If 
Next
End If
objF.Writeline("")
End If
'End If
End If
objRecordSet.MoveNext
Loop
objF.Close

Function ping(computer)
If computer= "" Then
ping = 1
Else
Dim PINGIT,WshShell
set WshShell = CreateObject ("Wscript.shell")
PINGIT="cmd /c ping.exe " & computer & " | find /I " & CHR(34) & "octets=" & CHR(34)
ping = WshShell.Run(PINGIT,1,True)
End If
End Function