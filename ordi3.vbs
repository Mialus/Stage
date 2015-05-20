Option Explicit

Dim WMIService
Dim KvpComponents
Dim VMList
Dim VM
Dim item
Dim component

Dim strComputer
'Get instance of 'virtualization' WMI service on the local computer
strComputer = "."
Set WMIService = GetObject("winmgmts:\\" & strComputer & "\root\virtualization")

'Get all the MSVM_ComputerSystem object
Set VMList = WMIService.ExecQuery("SELECT * FROM Msvm_ComputerSystem")   
For Each VM In VMList  
 if VM.Caption = "Virtual Machine" then      
  WScript.Echo "========================================"      
  WScript.Echo "VM Name: " & VM.ElementName      
  WScript.Echo "VM GUID: " & VM.Name     
  WScript.Echo "VM State: " & VM.EnabledState   
 end if
Next

' Get the list of KvpComponents
Set KvpComponents = WMIService.ExecQuery("SELECT * FROM Msvm_KvpExchangeComponent") '.ItemIndex(0)

For Each component in KvpComponents

 ' ensure that we are displaying the correct settings for the VM based on its instance ID/Name (you would need to replace the ID with the right one below)
 If component.SystemName = "AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA" then

  Dim GuestItems
  GuestItems = component.GuestIntrinsicExchangeItems
 
  ' Now enumerate the Msvm_KvpExchangeDataItem's that are in XML format
  For Each item In GuestItems
   WScript.Echo "========================================"      
   ' if you wanted the FullyQualifiedDomainName or OSName for the VM, you need to parse the XML
   ' returned and you can get that value
   Wscript.Echo item
  Next
 End If
Next