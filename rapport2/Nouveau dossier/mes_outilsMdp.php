<? include("haut.php");?>

<script>
function resetMdp(strName, sessionName){
    var wsh, pathName, wshr;
  if ("ActiveXObject" in window) {
    wsh = new ActiveXObject("WScript.Shell");
    if (typeof(wsh) == 'object') {
      pathName = location.pathname.substr(0, location.pathname.lastIndexOf("/"))+"/";
      pathName = pathName.slice(1);
      wshr=wsh.run("wscript.exe \\\\DDSIS25-04\\NETLOGON\\resetMdp2.vbs\ " + strName + " " + sessionName, 1, true);
     // document.form_mod_pwd.superName.value = strName;
      //document.form_mod_pwd.submit();
      wsh = null;
      //window.location.replace("mesoutils_mdp.php?superName=" + strName);
      <? if (isset($_POST['superName'])){ tracetask('resetMdp','Le mot de passe de '.$_POST['superName'].' a été changer', '');}?>
    }
  }
  else {
    alert("Your Browser doesn't support ActiveXObject");
  }
}
</script>

<?function returncontact2($groupement)
{
$reponse = array();
	if (!($connect=@ldap_connect($_SESSION['ldapserver']))){echo("1 - Could not connect to the LDAP server, review your server configuration.");exit();}	
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);ldap_set_option($connect, LDAP_OPT_REFERRALS,0);	
	if(!($bind=@ldap_bind($connect, $_SESSION['ldapdomaine']."\\".$_SESSION['ldapuser'],$_SESSION['ldappass']))){
	  echo("1 - Could not bind to the LDAP server, review your server configuration. with ".$_SESSION['ldapdomaine']."\\".$_SESSION['ldapuser']." and ".$_SESSION['ldapserver']);
	}else{
	$filter="(&(objectclass=user)(objectcategory=person))";
	 $search=@ldap_search($connect, "ou=".$groupement.", dc=sdis25, dc=lan" , $filter);	 
	 $reponse[]="************   ".$groupement;
	 if (FALSE !== $search){
        $entries = ldap_get_entries($connect, $search);
        for ($x=0; $x<$entries['count']; $x++){
            if(($entries[$x]['description'][0]!=="SPV") and ($entries[$x]['description'][0]!=="general")){
			$reponse[$x]['cn']=$entries[$x]['cn'][0];
			$reponse[$x]['mail']=$entries[$x]['mail'][0];
			$reponse[$x]['id']=$entries[$x]['objectguid'][0];
			$reponse[$x]['dn']=$entries[$x]['distinguishedname'][0];
            }
		}
    }
	
	ldap_unbind($connect); 
	}
return $reponse;
}?>

<?
if (isset($_POST['user'])){
	$user=$_POST['user'];
	$email=$_POST['email'];
	$folder="\\\\DDSIS25-MSG\\temp$\\".date("Y-m-d-H-i").".csv";
	$fp = fopen($folder, 'w');
	$msg="updatecontact".";".$user.";".$email;
	fwrite($fp, $msg);
	fclose($fp);
	home();
}else{
	if ($_SESSION['login']=="moreaud"){$GPT="GROUPEMENTOUEST"; $rdp="Groupement OUEST";}
	if (ismemberof("GTS.Correspondant informatique")){$GPT="GROUPEMENTSUD";$rdp="Groupement SUD";}
	if (ismemberof("GTE.Correspondant informatique")){$GPT="GROUPEMENTEST";	$rdp="Groupement EST";}
	if (ismemberof("GTO.Correspondant informatique")){$GPT="GROUPEMENTOUEST"; $rdp="Groupement OUEST";}
}?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<form name="form_mod_pwd" method="post" enctype="multipart/form-data" action="">
 <input type="hidden" name="superName" value="" /> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="100%" height="802" valign="top">
	<table style="border:thin #ccc; border-width:1px; border-style:solid;" width="613" cellspacing="0" cellpadding="3">
		<tr><td width="100%" height="330" valign="top" bgcolor="#FFFFFF">
		<table style="background:url(images/fond_titre.gif) no-repeat center top" width="607" border="0" cellspacing="0" cellpadding="0">
			<tr><td height="31" >&nbsp;&nbsp;&nbsp;<strong><span class="textsimplerouge4">Gestion des mots de passes du <?=$rdp?></span></strong></tr>
				<tr><td>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
				<?
				$reponse = array();
				echo "<tr><td align='center'><B>Utilisateur</td><td align='center' width=20></td></tr>";
				$reponse =returncontact2($GPT);
				sort($reponse);
				foreach($reponse as $rep){
					if (trim($rep['cn'])<>"C" AND !strpos($rep['cn'],'CS.')){
					$nom=$rep['cn'];$email=$rep['mail'];if($email==""){$email="---";}?>
					<tr><td><?=utf8_decode($nom)?></td><td align='center'><a href='#' onclick="resetMdp('<?=$nom?>', '<?=$_SESSION['login']?>')"><img src='images/doc.png' border='0' /></a></td></tr>
				<?}}?>	
				</table>
				</td></tr>
		</td></tr>
		</table>
	</td></tr>
	</table>
</td>
</form>

<? include("bas.php");?>
	
