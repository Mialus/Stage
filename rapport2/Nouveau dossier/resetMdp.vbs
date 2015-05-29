Option Explicit
Const ADS_SCOPE_SUBTREE = 2 
Dim strPassword, strUser, objConnection, objCommand, objRecordSet, objRootDSE, objOU, valid, dir1, objFSo, objShell, ofile

Function create_log(session, Pfilename,info1,info2)
 dir1 = "C:\eventlog1.html"
 Set objFSO = CreateObject("Scripting.FileSystemObject")
	Set objShell = CreateObject("WScript.Shell")
	Set ofile=objFSO.CreateTextFile(dir1,True)
	
	'Write the HTML form
	ofile.Write "<?"
	ofile.Write "$ourFileName = 'D:\\xampp\\htdocs\\amenothes\\script\\logs\\" & Pfilename & ".log';"
	ofile.Write "$ourFileHandle = fopen($ourFileName, 'a+') or die('can't open file');"
	ofile.Write "$stringData = date('Y-m-d H:i:s').' - " & session & "'\r\n';"
	ofile.Write "fwrite($ourFileHandle, $stringData);"
	ofile.Write "$stringData = '   '" & info1 & "'\r\n';"
	ofile.Write "fwrite($ourFileHandle, $stringData);"
	ofile.Write "$stringData = '   '" & info2 & "'\r\n';"
	ofile.Write "fwrite($ourFileHandle, $stringData);"
	ofile.Write "fclose($ourFileHandle);"
	ofile.Write "?>"
 ofile.close
 'objFSo.DeleteFile dir1
End Function

Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"
Set objCommand.ActiveConnection = objConnection
objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE

objCommand.CommandText = "Select Name, ADsPath from 'LDAP://DC=sdis25,DC=lan' Where objectClass='user'" 
Set objRecordSet = objCommand.Execute

valid = 0

strUser = WScript.Arguments(0)+ " " + Mid(WScript.Arguments(1), 1, 1) + LCase(Mid(WScript.Arguments(1), 2, Len(WScript.Arguments(1))-1))
While (valid=0)
objRecordSet.MoveFirst
strPassword = inputbox( "Nouveau mot de passe de " + strUser + vbCr + "(6 caractères minimums, une majuscule, une minuscule, et un chiffre obligatoire, )", "Changement de mot de passe" )

If (Len(strPassword)>1) Then


	Do Until objRecordSet.EOF
		If objRecordSet.Fields("Name").Value=strUser Then
			Set objOU = GetObject(objRecordSet.Fields("ADsPath").Value)
			objOU.SetPassword strPassword
			objOU.Put "pwdLastSet", 0
			objOU.SetInfo
			If Err.Number = 0 Then
				valid=1
				Call create_log(WScript.Arguments(2),"resetMdp","Le mot de passe de " & strUser & " a été changer", "")
				WScript.Echo "Le mot de passe est changé"
			End If
		End If
	objRecordSet.MoveNext
	Loop
	If Err.Number <> 0 Then
    	WScript.Echo "Le mot de passe ne respect pas les conditions de sécuritées."
	End If
Else
valid = 1
End If
Wend
WScript.Quit 