Option Explicit
Const ADS_SCOPE_SUBTREE = 2 
Dim strPassword, strUser, objConnection, objCommand, objRecordSet, intAccValue, objRootDSE, objOU, objItem

Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"
Set objCommand.ActiveConnection = objConnection
objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE

objCommand.CommandText = "Select Name, ADsPath from 'LDAP://DC=sdis25,DC=lan' Where objectClass='user'" 
Set objRecordSet = objCommand.Execute

strUser = inputbox( "user", "Input" )
strPassword = inputbox( "Nouveau mot de passe", "Input" )
intAccValue = 544


Do Until objRecordSet.EOF
If objRecordSet.Fields("Name").Value=strUser Then
 
Set objOU = GetObject(objRecordSet.Fields("ADsPath").Value)  
WScript.Echo "test"

objOU.SetPassword strPassword
objOU.Put "userAccountControl", intAccValue
objOU.SetInfo
WScript.Echo objRecordSet.Fields("Name").Value

End If
objRecordSet.MoveNext
Loop

WScript.Quit 