Option Explicit
Const ADS_SCOPE_SUBTREE = 2 
Dim strPassword, strUser, objConnection, objCommand, objRecordSet, objRootDSE, objOU

Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"
Set objCommand.ActiveConnection = objConnection
objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE

objCommand.CommandText = "Select Name, ADsPath from 'LDAP://DC=sdis25,DC=lan' Where objectClass='user'" 
Set objRecordSet = objCommand.Execute

strUser = WScript.Arguments(0)+ " " + Mid(WScript.Arguments(1), 1, 1) + LCase(Mid(WScript.Arguments(1), 2, Len(WScript.Arguments(1))-1))
strPassword = inputbox( "Nouveau mot de passe de " + strUser + vbCr + "(6 caractères minimums, une majuscule, une minuscule, et un chiffre obligatoire, )", "Input" )

On Error Resume Next
Do Until objRecordSet.EOF
If objRecordSet.Fields("Name").Value=strUser Then
If (Len(strPassword)>1) Then
Set objOU = GetObject(objRecordSet.Fields("ADsPath").Value)

objOU.SetPassword strPassword
objOU.Put "pwdLastSet", 0
objOU.SetInfo
If Err.Number = 0 Then
WScript.Echo "Le mot de passe est changé"
End If
End If
End If
objRecordSet.MoveNext
Loop
If Err.Number <> 0 Then
    WScript.Echo "Le mot de passe ne respect pas les conditions de sécuritées."
    Err.Clear
End If
WScript.Quit 