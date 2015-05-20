'Prompts for VM name returns error if blank
VMName = InputBox("Please Enter the VM Name","Enter VM Name")
If VMName = "" Then
call MsgBox("No name was given",vbOKOnly,"Error")
WScript.Quit
Else
strVM = VMName
End If
Technorati Tags: Hyper-V,VBScript

 

'executes powershell to check for host value
pscommand = " reg query ‘\\" & strVM & "\HKLM\SOFTWARE\Microsoft\Virtual Machine\Guest\Parameters’ /v PhysicalHostNameFullyQualified "
cmd = "powershell.exe -noprofile -command " & pscommand
Set shell = CreateObject("WScript.Shell")
Set executor = shell.Exec(cmd) executor.StdIn.Close
strA = executor.StdOut.ReadAll

'Displays host machine or error if nothing returned
If strA = "" Then
call MsgBox(strVM & " is not a virtual machine or is unreachable",vbOKOnly,"Error")
WScript.Quit
else
MsgBox strVM & " resides on:" & Replace(Replace(strA,"HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Virtual Machine\Guest\Parameters","")," PhysicalHostNameFullyQualified REG_SZ ","")
End If