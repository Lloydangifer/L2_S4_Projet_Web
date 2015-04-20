<?php 
include('bibli_24sur7.php');
session_start();
lsvm_verifie_session();
$lsvm_db_req=lsvm_db_connexion();
$id=$_SESSION['id'];
lsvm_html_head('24sur7 | Agenda');
lsvm_html_bandeau(APP_PAGE_RECHERCHE);
echo '<section id="bcContenu">';
	if (isset($_POST['btnAbo'])) {
		$utiAbo=$_POST['abo'];
		$sqlAbo = "INSERT INTO suivi (suiIDSuiveur, suiIDSuivi)
			VALUES ('$id','$utiAbo')";
		$resultAbo = mysqli_query($GLOBALS['bd'],$sqlAbo) or fd_bd_erreur($lsvm_db_req);
	}
	if (isset($_POST['btnDesabo'])) {
		$utiDesabo=$_POST['desabo'];
		$sqlDesabo = "DELETE FROM suivi
			WHERE suiIDSuiveur = '$id'
			AND suiIDSuivi = '$utiDesabo'";
		$resultDesabo = mysqli_query($GLOBALS['bd'],$sqlDesabo) or fd_bd_erreur($lsvm_db_req);
	}
	if (!isset($_POST['txtRecherche'])){
		$_POST['txtRecherche'] = '';
		$varTest='';
	}else{
		$varTest=lsvml_Recherche();
	}
	$zoneRecherche=lsvm_form_input(APP_Z_SEARCH, 'txtRecherche',$_POST['txtRecherche'], '40');
	$zoneBoutonRecherche=lsvm_form_input(APP_Z_SUBMIT, 'btnRechercher', 'Rechercher');
	$zoneBoutonDesabo=lsvm_form_input(APP_Z_SUBMIT, 'btnDesabo', 'Se désabonner');
	$zoneBoutonAbo=lsvm_form_input(APP_Z_SUBMIT, 'btnAbo', 'S\'abonner');
	echo '<section id="bcCentreRecherche"><form method="POST" action="../php/recherche.php">';
	echo '<p class="zoneForm">Entrez le critère de recherche : ',$zoneRecherche,' ',$zoneBoutonRecherche,'</p></form></br>';
	echo $varTest;
	function lsvml_Recherche(){
		$txtRecherche = trim($_POST['txtRecherche']);
		$txtRecherche = mysqli_real_escape_string($lsvm_db_req, $txtRecherche);
		$sql="SELECT DISTINCT utiNom, utiMail, utiID
		FROM utilisateur
		WHERE utiNom LIKE '%".$_POST['txtRecherche']."%' OR utiMail LIKE '%".$_POST['txtRecherche']."%'
		ORDER BY utiNom";
		$result=mysqli_query($lsvm_db_req, $sql); //or fd_bd_erreur($sql);
		$i=0;
		$num=mysqli_num_rows($result);
		if ($num==0){
			$rec = '<p>Pas de r&eacute;sultats.</p>';
		}else{
			$rec='<ul>';
			while ($enr=mysqli_fetch_assoc($result)){
				$utiID=$enr['utiID'];
				$sqlSuiv="SELECT suiIDSuivi
				FROM suivi
				WHERE suiIDSuivi = '$utiID'
				AND suiIDSuiveur = '$id'";
				$resultSuiv=mysqli_query($lsvm_db_req,$sqlSuiv) or fd_bd_erreur($sqlSuiv);
				$enrSuiv=mysqli_fetch_assoc($resultSuiv);
				if ($i==0){
					$rec.= '<li class="resRecherche1">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
					$i=1;
				}elseif($i==1){
					$rec.= '<li class="resRecherche2">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
					$i=0;
				}
				if($enrSuiv['suiIDSuiveur'] == $enr['utiID']){
					$rec.= ' [Abonn&eacute; à votre agenda]';				
				}
				if ($id!=$utiID){
					if($enrSuiv['suiIDSuivi']==$enr['utiID']){
						$rec.= '<span class="btnAbo"><form method="POST" action="../php/recherche.php">'.$zoneBoutonDesabo;
						lsvm_form_input(APP_Z_HIDDEN, 'desAbo', $enr['utiID'], 40);
					}else{
						$rec.= '<span class="btnAbo"><form method="POST" action="../php/recherche.php">'.$zoneBoutonAbo;
						lsvm_form_input(APP_Z_HIDDEN, 'abo', $enr['utiID'], 40);
					}
				}
				$rec.= '</span></form></li>';
			}
			$rec.= '</ul>';
		}
		return $rec;
	}
	echo '</section></section>';
lsvm_html_pied();
?>
