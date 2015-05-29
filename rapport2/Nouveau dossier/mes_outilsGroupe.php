<? include("haut.php");?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<form name="form_mod_pwd" method="post" enctype="multipart/form-data" action="">
 <input type="hidden" name="superName" value="" /> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="100%" height="802" valign="top">
	<table style="border:thin #ccc; border-width:1px; border-style:solid;" width="613" cellspacing="0" cellpadding="3">
		<tr><td width="100%" height="330" valign="top" bgcolor="#FFFFFF">
		<table style="background:url(images/fond_titre.gif) no-repeat center top" width="607" border="0" cellspacing="0" cellpadding="0">
			<tr><td height="31" >&nbsp;&nbsp;&nbsp;<strong><span class="textsimplerouge4">Gestion des Groupes</span></strong></tr>
				<tr><td>
				<?$groupe=groupegestion();
		if ($groupe<>""){?>
        <table width="100%" border="0">
              <tr bgcolor="#424242"><td colspan=7><font size="3" color="white">Gestion des groupes</font></td></tr>
			<?for($k=0;$k<count($groupe);$k++){?>
			<tr Onclick="aff_cache('b<?=$k?>');"><td colspan=3><img src="images/application.gif" style="border:none" width="15" height="15" /> <font size="3" color="blue"><?=$groupe[$k]?> <font size="3"><i>(cliquer pour ouvrir/fermer)</td></tr>
				<tr><td><table width="100%" border="0" id="b<?=$k?>"  bgcolor="#EFFBFB" > 
				 <?	$liste= listmembergroup($groupe[$k]);
					if(COUNT($liste)>0){
					sort($liste);
					$liste2=$liste;
					for($i=1;$i<COUNT($liste);$i++){	
					  $liste2[$i]=str_replace("CN=","",$liste2[$i]);
					  $chaine=$liste[$i];
					  $pos = strpos($liste2[$i], ',');		
					  $liste2[$i]= substr($liste2[$i],0, $pos);
					  }
					}
					?>		 
					 <tr><td colspan=3 align='right'>Sélectionnez un agent à ajouter ou à supprimer du groupe:</td></tr>
					 <tr><td>					 
						 <select name="user" id="user<?=$k?>" onchange="displaychange(<?=$k?>,'')">
						 <option value="">---</option>
						  <? 
						  $query3="select * from user order by sn, prenom";
						  $exec3 = mysql_query($query3) or die(mysql_error());
						  while($data3 = mysql_fetch_assoc($exec3)){
						  if($data3['sn']<>''){
							$chaine=$data3['sn']." ".$data3['prenom']." (".$data3['physicaldeliveryofficename'].") ";	
							if(in_array($data3['sn']." ".$data3['prenom'], $liste2)){	
								$chaine=$chaine." ----- "?>
								<option  style='background-color:yellow;' value='<?=$data3['login']."/"?>'><?=$chaine?></option>
							<?}else{?>
								<?if($data3['LAO_NOM']==""){$color="white";}else{$chaine=$chaine." ----- ".$spc; $color="#F5A9F2";}?>
								<option   style='background-color:<?=$color?>;' value='<?=$data3['login']?>'><?=$chaine?></option>
						  <?}}}?>	
						</select></td><td>
						<input type='button'  id="add<?=$k?>" onclick="addagent('user<?=$k?>','<?=$groupe[$k]?>')" value="Ajouter dans <?=$groupe[$k]?>" />						
						<input type='button'  id="del<?=$k?>" onclick="delagent('user<?=$k?>','<?=$groupe[$k]?>')" value="Retirer de <?=$groupe[$k]?>" />
					</td></tr>
							<?for($i=1;$i<COUNT($liste);$i++){?>
							<tr><td><?=$liste2[$i]?></td></tr>
						<?}?>
							<tr height="10"><td></td></tr>
				<script>cache('b<?=$k?>'); displaychange(<?=$k?>, 'a');</script>			
				 </table></td></tr>
			<?}?>	
        </table>
		<?}?>
				</td></tr>
		</td></tr>
		</table>
	</td></tr>
	</table>
</td>
</form>

<? include("bas.php");?>
	
