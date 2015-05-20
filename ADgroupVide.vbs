'Define Constants
Const ADS_SCOPE_SUBTREE = 2 ' Search target object and all sub levels
Const ForReading = 1, ForWriting = 2

'Count number of occurrence of string in another string
Function NbOc(chaine, ch)
chaine2 = Replace(chaine, ch, "")
NbOc = Len(chaine) - Len(chaine2) / Len(ch)
End Function

'send message
Function mail(sujet, message)
	on error resume next
	Dim destmail
	With CreateObject("CDO.Message") 
	.From="administrateur@sdis25.fr" 
 	'destmail = "Alerteexploitation@sdis25.fr"
	destmail = "Pierre.Wargnier@sdis25.fr"
	.To=destmail 
	.Subject= sujet 
	.TextBody= message
	.Configuration.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
	.Configuration.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "192.168.0.6"
	.Configuration.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
	.Configuration.Fields.Update 
	On Error Resume Next 
	.Send 
	End With 
 End function


'Create Objects
Set objShell = WScript.CreateObject("WScript.Shell")

'Create file
   Dim rapp
   Dim rapp2
'Construct an ADsPath to the Current Domain with rootDSE
Set objRootDSE = GetObject("LDAP://rootDSE")
strADsPath = "LDAP://" & objRootDSE.Get("defaultNamingContext")

'Connect to Active Directory
Set objConnection = CreateObject("ADODB.Connection")
Set objCommand = CreateObject("ADODB.Command")
objConnection.Provider = "ADsDSOObject"
objConnection.Open "Active Directory Provider"
Set objCommand.ActiveConnection = objConnection
objCommand.Properties("Page Size") = 1000
objCommand.Properties("Searchscope") = ADS_SCOPE_SUBTREE

objCommand.CommandText = "SELECT ADsPath,member FROM '" & strADsPath & _
"'" & " WHERE objectClass='group'"
Set objRecordSet = objCommand.Execute

'Start function
rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
If objRecordSet.EOF Then
	 rapp=rapp & "No groups found"
	 rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
Else

	rapp=rapp & "Liste des groupes Vides" & vbCr
	rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
	objRecordSet.MoveFirst
	Do Until objRecordSet.EOF
		strGroupName = objRecordSet.Fields("ADsPath").Value
		arrMembers = objRecordSet.Fields("member").Value
		If IsNull(arrMembers) Then
				nbFinNom = InStr(strGroupName,"OU=")
					If (nbFinNom > 0) Then
						nbFinNom = nbFinNom - 12
						Name2 = Mid(strGroupName, 11, nbFinNom)
						nbFinNom = nbFinNom + 15
						nbFinOU = InStr(strGroupName,",DC=")
						nbFinOU=nbFinOU-nbFinNom
						ou= Mid(strGroupName, nbFinNom, nbFinOU)
						i = NbOc(ou,",")
						tab = split(ou,",")
						If (InStr(tab(i),"DIR") or InStr(tab(i),"GROUPEMENTOUEST") or InStr(tab(i),"GROUPEMENTEST") or InStr(tab(i),"GROUPEMENTSUD")) THEN
							Do While i > -1

								nbFinNom = InStr(tab(i),"OU=")
								If (i = NbOc(ou,",")) then
								rapp=rapp & Name2
								rapp=rapp & "  --->  "
								End If

									If (nbFinNom > 0) Then
										nb=Len(tab(i))-3
										name=Mid(tab(i), 4, nb)
										rapp=rapp & name
										rapp=rapp & " / "
									Else
										rapp=rapp & tab(i)
									End If
								i=i-1
							Loop
							rapp=rapp & vbCr
							rapp=rapp & vbCr
							End If
	 				End If
		End If
		objRecordSet.MoveNext		
	Loop
End If

Const ADS_UF_ACCOUNTDISABLE = 2
objCommand.CommandText = _
 "<LDAP://dc=sdis25,dc=lan>;(&(objectCategory=User)" & _
        "(userAccountControl:1.2.840.113556.1.4.803:=2));Name,ADsPath,userPassword;Subtree"  
Set objRecordSet = objCommand.Execute

intCounter = 0
ReDim tab2(1)
ReDim tab3(1)
it=0
rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
If objRecordSet.EOF Then
WScript.Echo VbCrLf & "A total of " & intCounter & " accounts are disabled."
rapp=rapp & "A total of " & intCounter & " accounts are disabled."
Else
	rapp=rapp & "Liste des Utilisateurs désactivés" & vbCr
	rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
	objRecordSet.MoveFirst
	Do Until objRecordSet.EOF
		way=objRecordset.Fields("ADsPath")
		If (InStr(way,"Users")=0) Then
		nbFinNom = InStr(way,",")
				If (nbFinNom > 0) Then
					nbFinNom = nbFinNom - 12
					Name2 = Mid(way, 11, nbFinNom)
					nbFinNom = nbFinNom + 16
					nbFinOU = InStr(way,",DC=")
					nbFinOU=nbFinOU-nbFinNom
					ou= Mid(way, nbFinNom, nbFinOU)
					i = NbOc(ou,",")
					tab = split(ou,",")

					Do While i > -1
					
					nbFinNom = InStr(tab(i),"OU=")
						If (InStr(ou,"SPV")) Then						
								If (i = NbOc(ou,",")) then
								rapp=rapp & Name2
								rapp=rapp & "  --->  "
								End If

									If (nbFinNom > 0) Then
										nb=Len(tab(i))-3
										name=Mid(tab(i), 4, nb)
										rapp=rapp & name
										rapp=rapp & " / "
									Else
										rapp=rapp & tab(i)
									End If
						Else
							
							If (UBound(tab3)<it) Then
							ReDim Preserve tab3(UBound(tab3) +1)
							ReDim Preserve tab2(UBound(tab2) +1)
							End If
								If (i = NbOc(ou,",")) Then
								tab3(it)=Name2 & "  --->  "
								End If

								If (nbFinNom > 0) Then
									nb=Len(tab(i))-3
									name=Mid(tab(i), 4, nb)
									tab2(it)= tab2(it) & name & " / "
								Else
									tab2(it)= tab2(it) & tab(i)
								End If
						End If
						i=i-1
						Loop
					End If
        intCounter = intCounter + 1
        If (InStr(ou,"SPV")=0) Then
		it = it + 1
		End If
		If (InStr(ou,"SPV")) Then
		rapp=rapp & vbCr
		rapp=rapp & vbCr
		End If
		End If
		WScript.Echo objRecordset.Fields("userPassword").Value
    objRecordset.MoveNext
Loop
 For i=0 To UBound(tab2)
 rapp=rapp & tab3(i)
 rapp=rapp & tab2(i)
 rapp=rapp & vbCr
 rapp=rapp & vbCr
 Next
rapp=rapp & "A total of " & intCounter & " accounts are disabled." & vbCr
End If

objCommand.CommandText = "Select Name, ADsPath from 'LDAP://CN=Computers,DC=sdis25,DC=lan' Where objectClass='computer'" 
Set objRecordSet = objCommand.Execute
objRecordSet.MoveFirst

rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
rapp=rapp & "Liste des Ordinateurs dans l'OU Computer" & vbCr
rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr

Do Until objRecordSet.EOF
rapp=rapp & objRecordSet.Fields("Name").Value  & vbCr
objRecordSet.MoveNext
Loop

objCommand.CommandText = "Select Name, ADsPath from 'LDAP://OU=OU-INCONNUE,DC=sdis25,DC=lan' Where objectClass='user'" 
Set objRecordSet = objCommand.Execute
objRecordSet.MoveFirst

rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
rapp=rapp & "Liste des Utilisateurs dans l'OU OU-INCONNUE" & vbCr
rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr

Do Until objRecordSet.EOF
rapp=rapp & objRecordSet.Fields("Name").Value  & vbCr
objRecordSet.MoveNext
Loop

rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr
rapp=rapp & "Liste des Utilisateurs dont la dernière connection remonte à plus de deux ans" & vbCr
rapp=rapp & "-----------------------------------------------------------------------------------------------------------" & vbCr

on error resume next
Err.clear
' Define Variables
Dim strDomainDN, strAD1, OUFilter

OUFilter = "" ' eg: OU=Employees, end it with a comma if you have anything here.

' Domain List
Dim rootDSE
Set rootDSE = GetObject("LDAP://RootDSE")
strConfig = rootDSE.Get("configurationNamingContext")
DomainContainer =  rootDSE.Get("defaultNamingContext")
Set conn = CreateObject("ADODB.Connection")
conn.Provider = "ADSDSOObject"
conn.Open "ADs Provider"

' Use ADO to identify all domain controllers. Need to query them all since LastLogon isn't replicated.
strBase = "<LDAP://" & strConfig & ">"
strFilter = "(objectClass=nTDSDSA)"
strAttributes = "AdsPath"
strQuery = strBase & ";" & strFilter & ";" & strAttributes & ";subtree"

objCommand.CommandText = strQuery
objCommand.Properties("Page Size") = 100
objCommand.Properties("Timeout") = 120
objCommand.Properties("Cache Results") = False

Set adoRecordset = objCommand.Execute

' Generate a list of all AD controllers
d = 0
Do Until adoRecordset.EOF
    Set objDC = _
        GetObject(GetObject(adoRecordset.Fields("AdsPath").Value).Parent)
    ReDim Preserve arrstrDCs(d)
    arrstrDCs(d) = objDC.DNSHostName
    d = d + 1
    adoRecordset.MoveNext
Loop
adoRecordset.Close

' Going to need a place to hold LastLogon for comparison
Set objList = CreateObject("Scripting.Dictionary")
objList.CompareMode = vbTextCompare

' Need to know if we want Users, Computers or Both
Dim ldapStr
ldapFltr = "(&(objectCategory=person)(objectClass=user)" & "(!UserAccountControl:1.2.840.113556.1.4.803:=2))"

'strLogName = "LastLogon_" & TwoDigits(Year(now)) & TwoDigits(Month(now)) & TwoDigits(Day(now)) & TwoDigits(Hour(now)) & TwoDigits(Minute(now)) & TwoDigits(Second(now)) & ".csv"

' Obtain local Time Zone bias from machine registry.
' This bias changes with Daylight Savings Time.
lngBiasKey = objShell.RegRead("HKLM\System\CurrentControlSet\Control\" _
    & "TimeZoneInformation\ActiveTimeBias")
If (UCase(TypeName(lngBiasKey)) = "LONG") Then
    lngBias = lngBiasKey
ElseIf (UCase(TypeName(lngBiasKey)) = "VARIANT()") Then
    lngBias = 0
    For k = 0 To UBound(lngBiasKey)
        lngBias = lngBias + (lngBiasKey(k) * 256^k)
    Next
End If


For d = 0 To Ubound(arrstrDCs)
	nErrNo = 0
	'Create the LDAP query and execute
	If arrstrDCs(d)="DDSIS25-01.sdis25.lan" then
	strBase = "<LDAP://" & arrstrDCs(d) & "/" & OUFilter & DomainContainer & ">"
	strAttributes = "sAMAccountName,lastLogon"
    strQuery = strBase & ";" & ldapFltr & ";" & strAttributes & ";subtree"
	
	
	objCommand.CommandText = strQuery
	Set adoRecordset = objCommand.Execute
	nErrNo = Err.Number
	If nErrNo <> 0 Then 
		rapp=rapp & "Domain Controller not available: " & arrstrDCs(d) & " " & nErrNo
	Else
	
	'Hold one responding controller name, we're going to need it later.
	If IsEmpty(strAD1) Then
		strAD1 = arrstrDCs(d)
	End If
	
	'Process it
		While NOT adoRecordset.EOF
			Set objLastLogon = adoRecordset.Fields("lastLogon").Value
			Set strcn = adoRecordset.Fields(1).Value

			
			IF IsEmpty(adoRecordset.Fields("lastLogon").Value) Then
				lngHigh = 0
				lngLow = 0
			ElseIF IsNull(adoRecordset.Fields("lastLogon").Value) Then
				lngHigh = 0
				lngLow = 0
			Else			
				lngHigh = objLastLogon.HighPart
				lngLow = objLastLogon.LowPart
			End If

			
			If (lngLow < 0) Then
				lngHigh = lngHigh + 1
			End If
			   
			If (lngHigh = 0) And (lngLow = 0) Then
				strLastLogon = CDATE(#1/1/1601#) 'This should be never
			Else
				strLastLogon = #1/1/1601# + (((lngHigh * (2 ^ 32)) + lngLow)/600000000 - lngBias)/1440
			End If

			If (objList.Exists(adoRecordset.Fields("sAMAccountName").Value) = True) Then
				If (strLastLogon > objList(adoRecordset.Fields("sAMAccountName").Value)) Then
					objList.Item(adoRecordset.Fields("sAMAccountName").Value) = strLastLogon
				End If
			Else
				objList.Add adoRecordset.Fields("sAMAccountName").Value, strLastLogon
			End If
			
			adoRecordset.MoveNext
		Wend
	End If
	adoRecordset.Close
	Err.Clear
	End If
Next

'Query again so we can report other fields
strBase = "<LDAP://" & strAD1 & "/" & OUFilter & DomainContainer & ">"
strAttributes = "sAMAccountName,cn,givenName,sn,distinguishedName,objectCategory,mail"
strQuery = strBase & ";" & ldapFltr & ";" & strAttributes & ";subtree"

objCommand.CommandText = strQuery
Set adoRecordset = objCommand.Execute
Dim chem
' Write compiled data to the log
'rapp=rapp & "Display Name, Last Logon," & vbCr & vbCr

While NOT adoRecordset.EOF
chem = ""
	strGroupName = adoRecordSet.Fields("distinguishedName").Value
			nbFinNom = InStr(strGroupName,"OU=")
				If (nbFinNom > 0) Then
						nbFinOU = InStr(strGroupName,",DC=")
						nbFinOU=nbFinOU-nbFinNom
						ou= Mid(strGroupName, nbFinNom, nbFinOU)
						i = NbOc(ou,",")
						tab65 = split(ou,",")
							Do While i > -1

								nbFinNom = InStr(tab65(i),"OU=")
								If (i = NbOc(ou,",")) then
								chem=chem & "  --->  "
								End If

									If (nbFinNom > 0) Then
										nb=Len(tab65(i))-3
										name=Mid(tab65(i), 4, nb)
										chem=chem & name
										chem=chem & " / "
									Else
										chem=chem & tab65(i)
									End If
								i=i-1
							Loop
				End if	 							
	annee=CInt(Mid(objList.Item(adoRecordset.Fields("sAMAccountName").Value),7,4))
	an=Year(Now)-2
	If annee<an Then
	If (annee=1601)Then
	strObjectCategory = Mid(adoRecordset.Fields("objectCategory").value, 4, InStr(adoRecordset.Fields("objectCategory").value,",")-4)
	rapp2=rapp2 & CHR(34) & adoRecordset.Fields("cn").Value &  CHR(34) & "," _
		& CHR(34) & "Ce compte n'a jamais été connecté" & CHR(34) & chem & vbCr & vbCr
	Else
	strObjectCategory = Mid(adoRecordset.Fields("objectCategory").value, 4, InStr(adoRecordset.Fields("objectCategory").value,",")-4)
	rapp=rapp & CHR(34) & adoRecordset.Fields("cn").Value &  CHR(34) & "," _
		& CHR(34) & objList.Item(adoRecordset.Fields("sAMAccountName").Value) & CHR(34) & chem & vbCr & vbCr
	End If	
	End If
	adoRecordset.MoveNext
Wend
rapp = rapp & rapp2
adoRecordset.Close
objLogFile.close

objConnection.Close
Set RootDSE = Nothing
Set objConnection = Nothing
Set objCommand = Nothing
Set adoRecordset = Nothing
Set objDC = Nothing
Set objList = Nothing
Set objShell = Nothing
Set strAD1 = Nothing

Call mail("liste des comptes désactivés et des groupes vides dans l’AD ",rapp)