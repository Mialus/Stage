set WshShell = CreateObject("WScript.Shell") 'Show the script's window
WshShell.AppActivate "Internet Explorer"
Function ChooseOne(strTabDelimitedChoices)
'Returns one of several string choices. 
'Returns empty string if there is a problem.
Dim fs, web, doc
Dim strFile, strChoice
Dim intChars
Dim dtTime
	On Error Resume Next
	Set web = CreateObject("InternetExplorer.Application")
	If web Is Nothing Then
		ChooseOne = ""
		Exit Function
	End If
	'Increase displayed width to accomodate longest string choice
	intChars = 0
	For Each strChoice In Split(strTabDelimitedChoices,"/")
		If Len(strChoice) > intChars Then intChars = Len(strChoice)
	Next

	web.Width = 450
	web.Height = 200
	web.Offline = True
	web.AddressBar = False
	web.MenuBar = False
	web.StatusBar = False
	web.Silent = True
	web.ToolBar = False
	web.Navigate "about:blank"
	'Wait for the browser to navigate to nowhere
	dtTime = Now
	Do While web.Busy
		'Don't wait more than 5 seconds
		Wscript.Sleep 100
		If (dtTime + 5/24/60/60) < Now Then
			ChooseOne = ""
			web.Quit
			Exit Function
		End If
	Loop
	'Wait for a good reference to the browser document
	Set doc = Nothing
	dtTime = Now
	Do Until Not doc Is Nothing
		Wscript.Sleep 100
		Set doc = web.Document
		'Don't wait more than 5 seconds
		If (dtTime + 5/24/60/60) < Now Then
			ChooseOne = ""
			web.Quit
			Exit Function
		End If
	Loop
	'Write the HTML form
	doc.Write "<html><head><title>Suppression de Groupe</title></head>"
	doc.Write "<body><b>Choix du Groupe de " & strUser &" :</b><br><form><select name=""choice"">"
	For Each strChoice In Split(strTabDelimitedChoices,"/")
		doc.Write "<option value=""" & strChoice & """>" & strChoice
	Next
	doc.Write "</select>"
	doc.Write "<br><br><input type=button "
	doc.Write "name=submit "
	doc.Write "value=""OK"" onclick='javascript:submit.value=""Done""'>"
	doc.Write "</form></body></html>"
	'Show the form
	web.Visible = True
	'Wait for the user to choose, but fail gracefully if a popup killer.
	Err.Clear
	Do Until doc.Forms(0).elements("submit").Value <> "OK"
		Wscript.Sleep 100
		If doc Is Nothing Then
			ChooseOne = ""
			web.Quit
			Exit Function
		End If
		If Err.Number <> 0 Then
			ChooseOne = ""
			web.Quit
			Exit Function
		End If
	Loop
	'Retrieve the chosen value
	ChooseOne = doc.Forms(0).elements("choice").Value
	web.Quit
End Function
On Error Resume Next
Const ADS_SCOPE_SUBTREE = 2

Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"
Set objCommand.ActiveConnection = objConnection

objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE
strUser = WScript.Arguments(0)+ " " + Mid(WScript.Arguments(1), 1, 1) + LCase(Mid(WScript.Arguments(1), 2, Len(WScript.Arguments(1))-1))
cmdline="SELECT distinguishedName FROM 'LDAP://dc=sdis25,dc=lan' WHERE objectClass='user' AND Name='" & strUser & "'"


objCommand.CommandText = cmdline
Set objRecordSet = objCommand.Execute

objRecordSet.MoveFirst
Do Until objRecordSet.EOF
     UserDN = objRecordSet.Fields("distinguishedName").Value
    objRecordSet.MoveNext
Loop
i = 0
Dim group,group2
group=""
Set objUser = GetObject("LDAP://" & UserDN)
Set colGroups = objUser.Groups
For Each objGroup in colGroups
	If (i<>0)Then
	group = group & "/"
	End If
    group=group & objGroup.CN
    i=i+1
Next

group=ChooseOne(group)
For Each objGroup In colGroups

If (objgroup.CN=group) Then
group2 = objGroup.distinguishedName
End If
Next

Set Grp1 = GetObject("LDAP://" & group2 )
Grp1.Remove "LDAP://"  & UserDN
