<? include("haut.php");?>
<script>
function valider(num, email){
var person = prompt("Saisie de la nouvelle adresse Mail de l'agent : "+num, email);
if (person != null) {
	document.form_contacts.user.value = num;
	document.form_contacts.email.value = person;
    document.form_contacts.submit();
}}
</script>
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
<table width="840" border="0" cellspacing="0" cellpadding="0">
<form name="form_contacts" enctype="multipart/form-data" method="post" action="">
<input type="hidden" name="user" value="" />       
<input type="hidden" name="email" value="" />
<tr><td width="100%" height="802" valign="top">
	<table style="border:thin #ccc; border-width:1px; border-style:solid;" width="613" cellspacing="0" cellpadding="3">
		<tr><td width="100%" height="330" valign="top" bgcolor="#FFFFFF">
		<table style="background:url(images/fond_titre.gif) no-repeat center top" width="607" border="0" cellspacing="0" cellpadding="0">
			<tr><td height="31" >&nbsp;&nbsp;&nbsp;<strong><span class="textsimplerouge4">Gestion des contacts du groupement <?=$rdp?></span></strong></td></tr>
				<tr><td>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
				<?
				$reponse = array();
				echo "<tr><td align='center'><B>Utilisateur</td><td align='center' width=20>&nbsp;</td><td align='center'><B>Email</td></tr>";
				$reponse =returncontact($GPT);
				sort($reponse);
				foreach($reponse as $rep){
					if (trim($rep['cn'])<>"C" AND !strpos($rep['cn'],'CS.')){
					$nom=$rep['cn'];$email=$rep['mail'];if($email==""){$email="---";}?>
					<tr><td><?=utf8_decode($nom)?></td><td align='center'><a href='#' onclick="valider('<?=$nom?>','<?=$email?>')"><img src='images/doc.png' border='0' /></a></td><td><?=$email?></td></tr>
				<?}}?>	
				</table>
				</td></tr>
		</td></tr>
		</table>
	</td></tr>
	</table>
</td>


<? include("bas.php");?>
	
