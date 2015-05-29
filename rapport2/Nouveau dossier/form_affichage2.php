<?include("haut.php");?>
<?//if(!ismemberof("GTE.correspondant informatique") AND !ismemberof("GTO.correspondant informatique") AND !ismemberof("GTS.correspondant informatique")){home();}?>
<script type="text/javascript">

function appel(spot1, spot2, spot3 , spot4, spot5, spot6){
if (spot1.length==0){spot1='';}
if (spot2.length==0){spot2='';}
if (spot3.length==0){spot3='';}
if (spot4.length==0){spot4='';}
if (spot5.length==0){spot5='';}
if (spot6.length==0){spot6='';}
var msg = "form_affichage.php?spot=reparation_engin&spot1=" + spot1 + "&spot2=" + spot2 + "&spot3=" + spot3 + "&spot4=" + spot4 + "&spot5=" + spot5+ "&spot6=" + spot6;
window.location.href=msg;
}

function appel_fa(){
var msg = "form_affichage.php?spot=demande_fiche_agent" + document.form_affichage.fa_groupement.value + document.form_affichage.fa_onglet.value + document.form_affichage.fa_nonvalide.value;
window.location.href=msg;
}

function appel_fc(){
var msg = "form_affichage.php?spot=fiche_carburant" + document.form_affichage.cis.value;
window.location.href=msg;
}

function appel_lao(){
var msg = "registre_hygiene-fiche-export.php?spot=lao&m=" + document.form_affichage.lao.value ;
window.location.href=msg;
}

function appel_lao2(){
var msg = "registre_hygiene-fiche-export.php?spot=lao2&m=" + document.form_affichage.lao.value ;
window.location.href=msg;
}

function valider(num)
{
	if (confirm('Etes-vous sur de vouloir valider cette fiche ?')){
		window.location.href='ma_fiche.php?N='+num;
		}
}

function affiche_cache(ident) {
            if (document.getElementById(ident).style.visibility == "hidden") {
               document.getElementById(ident).style.visibility = "visible";
            } else {
               document.getElementById(ident).style.visibility = "hidden";
            }
}

</script>

<style type="text/css">
p.indent {
  margin-left: 1.5em;
}
</style>


<?
        $titre = "Diagnostic des disques serveurs";
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="76%" height="802" valign="top">
	<table  width="613" cellspacing="0" cellpadding="3">

		<tr><td width="605" height="330" valign="top" bgcolor="#FFFFFF">
		<table style="background:url(images/fond_titre.gif) no-repeat center top" width="607" border="0" cellspacing="0" cellpadding="0">
		  <tr><td height="31" >&nbsp;&nbsp;&nbsp;<strong><span class="textsimplerouge4">AFFICHAGE DU REGISTRE : <font size=3><i><?=$titre?></i></font></span></strong></td></tr>
		</table>
		
		<input type="hidden" name="ok" value="1" />		
		<table align="center" width="95%" cellpadding="3" cellspacing="0">														   	
		<?			$taille=600;
						$disk = array();
						$disk = serveur_disk();
                                                    if($_SESSION['login']=="wargnierp"){
                                                        $service = "GGO"; 
                                                    }else{
							$service = serveur_service(); 
							if($service==""){home();}
						}
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='DISK'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data3 = mysql_fetch_assoc($exec3);?>
						<tr><td colspan=3><table width="<?=$taille?>" border="0" bgcolor='#F8E0F7' cellpadding="0" cellspacing="0" >					
						<tr><td align="center" colspan=2><B>Données sur le serveur du groupement <?=$data3["SERVICE"]?></td></tr>
						<tr><td align="center" colspan=2><i>dernière mise à jour le <?=date_format(date_create($data3["date"]),"d/m/Y")." à ".date_format(date_create($data3["date"]),"H:i")?></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td colspan=2>Espace libre <B><?=$data3["A3"]?></B> sur <?=$data3["A1"]?></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr align='center'><td><a href="<?=$disk['groupement']?>">&rArr; Accès au disque du groupement</a></td><td><a href="<?=$disk['stockage']?>">&rArr; Accès au disque de stockage</a></td></tr>
						</table></td></tr>
						<?
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='video'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='video'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D1');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fichiers VIDEO - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D1"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){	
							$Tlen = intval($data3["A3"]);
							if (strpos($data3["A3"],"KB")>0){$Tcolor="#D8F6CE";}
							if (strpos($data3["A3"],"MB")>0){
								if ($Tlen<50){$Tcolor="#D8F6CE";}
								elseif ($Tlen>50 AND $Tlen<500){$Tcolor="#F3E2A9";}
								elseif ($Tlen>500){$Tcolor="#F78181";}
							}
							if (strpos($data3["A3"],"GB")>0){$Tcolor="#F78181";}
							?> <tr bgcolor="<?=$Tcolor?>"><td><?=$i++;?></td><td colspan=2><?=$data3["A2"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}
						?>	</table></td></tr><script>cache('D1');</script><?
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='audio'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);					
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='audio'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D2');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fichiers AUDIO - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D2"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){	
							$Tlen = intval($data3["A3"]);
							if (strpos($data3["A3"],"KB")>0){$Tcolor="#D8F6CE";}
							if (strpos($data3["A3"],"MB")>0){
								if ($Tlen<50){$Tcolor="#D8F6CE";}
								elseif ($Tlen>50 AND $Tlen<500){$Tcolor="#F3E2A9";}
								elseif ($Tlen>500){$Tcolor="#F78181";}
							}
							if (strpos($data3["A3"],"GB")>0){$Tcolor="#F78181";}					 
							?> <tr bgcolor="<?=$Tcolor?>"><td><?=$i++;?></td><td colspan=2><?=$data3["A2"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}
						?>	</table></td></tr><script>cache('D2');</script><?
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='taille'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);					
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='taille'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D7');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fichiers gros volume - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D7"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){	
							$Tlen = intval($data3["A3"]);
							if (strpos($data3["A3"],"KB")>0){$Tcolor="#D8F6CE";}
							if (strpos($data3["A3"],"MB")>0){
								if ($Tlen<50){$Tcolor="#D8F6CE";}
								elseif ($Tlen>50 AND $Tlen<500){$Tcolor="#F3E2A9";}
								elseif ($Tlen>500){$Tcolor="#F78181";}
							}
							if (strpos($data3["A3"],"GB")>0){$Tcolor="#F78181";}					 
							?> <tr bgcolor="<?=$Tcolor?>"><td><?=$i++;?></td><td colspan=2><?=$data3["A2"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}
						?>	</table></td></tr><script>cache('D7');</script><?					
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='older'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='older'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D3');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fichiers inutilisés depuis au moins 5 ans - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D3"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?					 
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){		
							?> <tr><td><?=$i++;?></td><td colspan=2><?=$data3["A2"]?></td></tr><?	
								}
						?>	</table></td></tr><script>cache('D3');</script><?
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='zerodir'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);					

						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D4');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dossiers vides - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D4"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?	
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='zerodir'";
						 $exec3 = mysql_query($query3) or die(mysql_error());						
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){?> <tr><td><?=$i++;?></td><td colspan=2><?=$data3["A1"]?></td></a></tr><?}
						?>	</table></td></tr><script>cache('D4');</script><?
						$query3 = "SELECT COUNT(*) AS NB FROM annuaire_disk WHERE SERVICE='".$service."' AND type='bigdir'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 $data2 = mysql_fetch_assoc($exec3);					

						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D5');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dossiers de taille importante - <?=$data2['NB']?> élément(s) trouvé(s)</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D5"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?							
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='bigdir' AND A4=0";
						 $exec3 = mysql_query($query3) or die(mysql_error());					 
						 $i=0;
						 ?> <tr><td align='center' colspan=2 bgcolor='yellow'>Dossier du premier niveau</td></tr><?
						 while($data3 = mysql_fetch_assoc($exec3)){												     
							?> <tr><td><?=$i++;?></td><td colspan=2><?=$data3["A1"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}	
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='bigdir' AND A4=1";
						 $exec3 = mysql_query($query3) or die(mysql_error());					 
						 $i=0;
						 ?> <tr><td align='center' colspan=2 bgcolor='yellow'>Dossier du second niveau</td></tr><?
						 while($data3 = mysql_fetch_assoc($exec3)){												     
							?> <tr><td><?=$i++;?></td><td colspan=2><?=$data3["A1"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}	
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='bigdir' AND A4>1";
						 $exec3 = mysql_query($query3) or die(mysql_error());					 
						 $i=0;
						 ?> <tr><td align='center' colspan=2 bgcolor='yellow'>Liste des sous-Dossier</td></tr><?
						 while($data3 = mysql_fetch_assoc($exec3)){												     
							?> <tr><td><?=$i++;?></td><td colspan=2><?=$data3["A1"]?> (<?=$data3["A3"]?>)</td></a></tr><?	
								}								
						?>	</table></td></tr><script>cache('D5');</script><?
						
						$query3 = "SELECT * FROM annuaire_disk WHERE SERVICE='".$service."' AND type='level'";
						 $exec3 = mysql_query($query3) or die(mysql_error());
						 ?>	<tr><td colspan=3><table width="<?=$taille?>" border="0" cellpadding="0" cellspacing="0" >
							 <tr bgcolor="#F2F2F2" Onclick="aff_cache('D6');"><td><img SRC="images/fleche_bas.gif" border=0></td>
							 <td colspan=6 align='center'><font size="3" color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Droits d'accès</font></td>
							 </tr>
							</table></td></tr>
							<tr><td colspan=3><table id="D6"  width="<?=$taille?>" border="1" cellpadding="0" cellspacing="0"><?
						 $i=0;
						 while($data3 = mysql_fetch_assoc($exec3)){
							$liste = str_replace("Admins du domaine(Lire, Ecrire, Suppression):","",$data3["A3"]);
							$liste = str_replace(":","<BR />",$liste);
							if ($data3["A1"]==""){$color="yellow";$puce="&nbsp;";}else{$color="";$puce="&raquo;";}
							?> <tr  bgcolor="<?=$color?>"><td><?=$puce?></td><td><?=$data3["A2"]?></td><?
							?><td><?=$liste?></td></tr><?							
								}
						?>	<script>cache('D6');</script>
						</table></td></tr>		   

				</td></tr>
                               
			</table>
	</form>
	</table>
	
<? include("bas.php");?>