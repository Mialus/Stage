<? include("haut.php");?> 

<script>
function runstat(groupement)
	{ 

	var WshShell = new ActiveXObject("WScript.Shell"); 

	switch (groupement)
	{ 
	  case "Groupement Est":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\GTEST-02\\f$"';
	  break; 
	  case "Groupement Ouest":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\h$"';
	  break; 
	  case "Groupement Sud":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\GTSUD-02\\f$"';
	  break; 
	  case "Groupement GAF":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\l$"';
	  break; 
	  case "Groupement GEC":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\m$"';
	  break;
	  case "Groupement Logistique":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\p$"';
	  break; 
	  case "Groupement Gestion opérationnelle":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\o$"';
	  break; 
	  case "Service SSSM":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\j$"';
	  break;
	  case "Groupement Prévention Planification":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\i$"';
	  break;
	  case "Direction":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02\\n$"';
	  break;
	  default:
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\WinDirStatPortable.exe \\\\DDSIS25-02"';
	  break;
	}
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function runadmin(groupement)
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 
	switch (groupement)
	{
	  case "Groupement Est":
	  command = '\\\\GTEST\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\system32\\mmc.exe \\\\GTEST-01\\netlogon\\Divers\\AdministrationGroupementEST.msc"';
	  break; 
	  case "Groupement Ouest":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\system32\\mmc.exe \\\\DDSIS25-04\\netlogon\\Divers\\AdministrationGroupementOUEST.msc"';
	  break; 
	  case "Groupement Sud":
	  command = '\\\\GTSUD\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\system32\\mmc.exe \\\\GTSUD-01\\netlogon\\Divers\\AdministrationGroupementSUD.msc"';
	  break; 
	  case "CS":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\system32\\mmc.exe \\\\DDSIS25-04\\netlogon\\Divers\\AdministrationCSCPI.msc"';
	  break; 
	  default:
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\system32\\mmc.exe \\\\DDSIS25-04\\netlogon\\Divers\\dsa.msc"';
	  break; 
	}
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function explore(groupement)
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 
	switch (groupement)
	{
	  case "Groupement Est":
	  command = '\\\\GTEST\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\explorer.exe \\\\GTEST-02\\f$"';
	  break; 
	  case "Groupement Ouest":
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\explorer.exe \\\\DDSIS25-02\\GTO.groupement ouest"';
	  break; 
	  case "Groupement Sud":
	  command = '\\\\GTSUD\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\explorer.exe \\\\GTSUD-02\\f$"';
	  break; 
	  default:
	  command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\explorer.exe \\\\DDSIS25-02"';
	  break; 
	}
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function sirdeconcentre()
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 

	command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"%windir%\\explorer.exe \\\\ddsis25-02\\SIR déconcentré$"';
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}


function runadminpak()
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 
	command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\Divers\\adminpak.exe /T:c:\\temp"';
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function runadminpak2()
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 
	command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\Divers\\adminpak2.msu /T:c:\\temp"';
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function runcdwrite()
	{ 
	var WshShell = new ActiveXObject("WScript.Shell"); 
	command = '\\\\DDSIS25-04\\NETLOGON\\lsrunas.exe /user:sauvegarde /password:4V55ne8L8A== /domain:sdis25 /runpath:c: /command:"\\\\DDSIS25-04\\NETLOGON\\tools\\cdbxpp.exe"';
	var oExec = WshShell.Exec(command);
	while (oExec.Status == 0)
		  {     
			Wait(1000);
		  }
	oExec = null;
	WshShell = null;
	}

function modmail(){
		var user=document.form_mesoutils.suser.value;	
		var email = prompt('Nouvelle addresse Email:'+user, '');
		if (email!=''){
			document.form_mesoutils.puser.value=user;	
			document.form_mesoutils.pemail.value=email;	
			document.form_mesoutils.ok.value='3';	
			document.form_mesoutils.submit();
		}
	}
	
function addagent(luser, groupe){
	var user=document.getElementById(luser).value;
	document.form_mesoutils.puser.value=user;	
	document.form_mesoutils.pgroupe.value=groupe;	
	document.form_mesoutils.ok.value='1';	
	document.form_mesoutils.submit();
}

function delagent(luser, groupe){
	var user=document.getElementById(luser).value;
	document.form_mesoutils.puser.value=user;	
	document.form_mesoutils.pgroupe.value=groupe;	
	document.form_mesoutils.ok.value='2';	
	document.form_mesoutils.submit();
}

	
function displaychange(value, org){
	if (org=='a'){
		document.getElementById('add'+value).style.display = 'none';
		document.getElementById("del"+value).style.display = 'none';	
	}else{
			var ucolor=document.getElementById('user'+value).value;		
		if(ucolor.indexOf('/')>0){
			document.getElementById("add"+value).style.display = 'none';
			document.getElementById("del"+value).style.display = 'block';				
		}else{
			document.getElementById("add"+value).style.display = 'block';
			document.getElementById("del"+value).style.display = 'none';		
		}
	}
}
</script>

<? 
if(isset($_POST['ok'])) {
	$vgroupe=$_POST['pgroupe'];
	$vuser=$_POST['puser'];
	$vemail=$_POST['pemail'];
	switch($_POST['ok']){
		case '1':
			addingroupeAD($vuser, $vgroupe);
			$msg="Ajout de ".$vuser." dans le groupe ".$vgroupe;
		break;
		case '2':
			removefromgroupeAD($vuser, $vgroupe);
			$msg="Suppression de ".$vuser." dans le groupe ".$vgroupe;
		break;	
		case '3':
			modifyldap($vuser, "proxyaddresses", "SMTP:".$vemail);
			modifyldap($vuser, "mail", $vemail);
			modifyldap($vuser, "targetaddress", $vemail);
			$query3="UPDATE user SET mail='".$vemail."' WHERE login='".$vuser."'";
			$exec3 = mysql_query($query3) or die(mysql_error());
			$msg="Modification adresse Mail de  ".$vuser." : ".$vemail;
		break;	
	}
	tracetask("GESTION_GROUPES",$vuser,$msg);
}
$groupe=groupegestion();

$GPT=$_SESSION['groupement'];
 $GPTF="\\\DDSIS25-02\\temp$";
if (ismemberof("GTS.Correspondant informatique")){$GPT="Groupement Sud";	$GPTF="\\\GTSUD-02\\temp$";	$dossier = "\\GTSUD-02\f$";	$rdp="Administration Groupement SUD.rdp";}

if (ismemberof("GTE.Correspondant informatique")){$GPT="Groupement Est";	$GPTF="\\\GTEST-02\\temp$";	$dossier="\\gtest-02\f$";$rdp="Administration Groupement EST.rdp";}

if (ismemberof("GTO.Correspondant informatique")){$GPT="Groupement Ouest"; $GPTF="\\\DDSIS25-02\\temp$"; $dossier="\\ddsis25-02\GTO.groupement ouest";$rdp="Administration Groupement OUEST.rdp";}?>

<form name="form_mesoutils" enctype="multipart/form-data" method="post" action="">
<input type="hidden" name="ok" value="1" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100%" valign="top">
                    <table style="border:thin #ccc; border-width:1px; border-style:solid;" width="600" cellspacing="0" cellpadding="3">
                      <tr>
                        <td width="600" height="1000" valign="top" bgcolor="#FFFFFF"><table style="background:url(images/fond_titre.gif) no-repeat center top" width="607" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="31" >&nbsp;&nbsp;&nbsp;<strong><span class="textsimplerouge4">Correspondants informatiques <?=$_SESSION['groupement'];?></span></strong></td>
                            </tr>
                          <tr height="10"><td></td></tr>
                          </table>
		<?if(false){?>
       <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Informations</font></td></tr>
              <?
                echo "<!--";
                $taille=(1/envoi_des_donnnes(100000))*100000;
                $debit=round(8*$taille/1000/envoi_des_donnnes($taille),0);
                $debit = number_format ($debit, 0,".", ",")." Mb/s";
                echo "-->";
              ?>
              <tr><td colspan=8><img src="images/telephone.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> Débit : <?=$debit?></font>
              <img src="images/telephone.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> Adresse IP: <?=$_SERVER['REMOTE_ADDR']?></font>
              <img src="images/telephone.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> Nom de station : <?=gethostbyaddr($_SERVER['REMOTE_ADDR']); ?></font></td></tr>
              <?
              if(ping("192.168.0.6", 200)>0){$Smessagerie=true;}else{$Smessagerie=false;}
              if(ping("192.168.22.6", 200)>0){$S1=true;}else{$S1=false;}
              if(ping("192.168.11.6", 200)>0){$S2=true;}else{$S2=false;}
              if(ping("192.168.0.5", 200)>0){$S3=true;}else{$S3=false;}
              if(ping("173.194.67.94", 200)>0){$S4=true;}else{$S4=false;}
              if(ping("192.168.0.2", 200)>0){$S5=true;}else{$S5=false;}
              ?>
              <tr><td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($Smessagerie ? 'color="green"' : 'color="red"')?>> Messagerie</font></td>
              <td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($S1 ? 'color="green"' : 'color="red"')?>> Gpt EST</font></td>
              <td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($S2 ? 'color="green"' : 'color="red"')?>> Gpt Sud</font></td>
              <td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($S5 ? 'color="green"' : 'color="red"')?>> Gpt OUEST</font></td>
              <td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($S3 ? 'color="green"' : 'color="red"')?>> Fichiers</font></td>
              <td><img src="images/racine.gif" style="border:none" width="15" height="15" /><font size="3" <?=($S4 ? 'color="green"' : 'color="red"')?>> Accès Internet</font></td></tr>
        </table>
		<?}?>
        <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Gestion des centres</font></td></tr>
              <tr><td><a href="infospv.php"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> SPV : comptes accès à l'Extranet</font></a></td></tr>
        </table>
		<?if($GPT<>""){?>
        <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Gestion des comptes</font></td></tr>
            <tr><td><a href="\\intranet\rdp\<?=$rdp?>"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Gestion de compte du <?=$GPT?></font></a></td></tr>
			<tr><td><a href="mes_outilsContacts.php"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Gestion de contacts du <?=$GPT?></font></a></td></tr>  
<tr><td><a href="mes_outilsGroupe.php"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Gestion de groupes du <?=$GPT?></font></a></td></tr>                        
			<?if ($_SESSION['login']=='moreaud' OR $_SESSION['login']=='wargnierp'){?>
				<tr Onclick="aff_cache('Tuser');"><td colspan=3>
				<img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">Messagerie : Comptes du SDIS25: <i>(cliquer pour ouvrir/fermer)</font></td></tr>		
				 <tr><td><table width="100%" border="0" id="Tuser" bgcolor="#EFFBFB" > 
					 <tr><td colspan=3 align='right'>Sélectionnez un agent pour modifier son adresse Email:</td></tr>
							 <tr><td align='right'>					 
								 <select name="suser" id="tuser" onchange="aff('idmodemail','')">
								 <option value="">---</option>
								  <? 
								  $rt=returnallexternalemail();
								  foreach($rt as $R){
									$chaine=$R['nom']." ".$R['prenom']." - ".$R['mail'];?>
										<option   style='background-color:<?=$color?>;' value='<?=$R['login']?>'><?=$chaine?></option>
								  <?}?>	
								</select></td><td>
								<input type='button'  id='idmodemail' onclick="modmail()" value="Modifier l'adresse mail" />						
							</td></tr>
					 </table></td></tr>
					<script>cache('Tuser');cache('idmodemail');</script>	
				<?}?>	 
        </table>

		
		
		
       <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Gestion du serveur</font></td></tr>
              <tr><td><a href="#" onclick="javascript:explore('<?=$GPT?>');return false;"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Gestion des accès disque <?=$GPT?></font></a></td></tr>
              <tr><td><a href="#" onclick="javascript:runstat('<?=$GPT?>');return false;"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Inventaire disque réseau <?=$GPT?></font></a></td></tr>
				<tr><td><a href="<?=$GPTF?>\filelist.csv" Target= "_blank"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Liste des fichiers sur le serveur</font></a></td></tr>			             
			 <tr><td><a href="#" onclick="javascript:sirdeconcentre();return false;"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue">  Accès à SIR déconcentré </font></a></td></tr>
        </table>
		<?}?>
        <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Outils techniques</font></td></tr>
              <tr><td><a href="speed.php"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> Mesure du débit station vers serveur Intranet</font></a></td></tr>
              <tr><td><a href="userfiles\file\ressources_adm_techniques_reglementation\RI_annexe21_dotation_materiel_informatique_bureautique.pdf"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> annexe21 : dotation materiel informatique et bureautique</font></a></td></tr>
              <tr><td><a href="#" onclick="javascript:runcdwrite();return false;"><img src="images/application.gif" style="border:none" width="15" height="15" /><font size="3" color="blue"> Outil de gravage de CD/DVD</font></a></td></tr>
              <tr height="10"><td></td></tr>
        </table>


    </td></tr>
</table></td>

<? include("bas.php");?>

