<?php
/** @file
 * Page de recherche de l'application 24sur7
 *
 * Effectue une recherche dans l'application et renvoie les abonnements et désabonnement éventuelle
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 * @author : Sammy Loudiyi - sammy.loudiyi@edu.univ-fcomte.fr
 *
 */ 
include('bibli_24sur7.php');
//Fonction d'en-tête
lsvm_html_head('24sur7 | Agenda');
//Fonction du bandeau
lsvm_html_bandeau(APP_PAGE_RECHERCHE);
	echo '<section id="bcContenu">';
	//Ouverture et vérification de session
	session_start();
	lsvm_verifie_session();
	/**
	* Fonction de recherche
	*
	* Effectue une recherche dans la base de donnée par rapport à la variable $_POST. Affiche si l'utilisateur est abonnée ou non aux résultats, et si le résultats est abonné à l'utilisateur. Pas de paramètre
	*/
	function lsvml_Recherche(){
		$lsvm_db_req=lsvm_db_connexion();
		$txtRecherche = trim($_POST['txtRecherche']);
		$txtRecherche = mysqli_real_escape_string($lsvm_db_req, $txtRecherche);
		$sql="SELECT DISTINCT utiNom, utiMail, utiID
		FROM utilisateur
		WHERE utiNom LIKE '%{$txtRecherche}%' OR utiMail LIKE '%{$txtRecherche}%'
		ORDER BY utiNom";
		$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($sql);
		$i=0;
		$num=mysqli_num_rows($result);
		if ($num==0){
			$recherche = '<p>Pas de résultats.</p>';
		}else{
			$recherche='<ul>';
			while ($enr=mysqli_fetch_assoc($result)){
				$id=$_SESSION['id'];
				$utiID=$enr['utiID'];
				$zoneBoutonDesabo=lsvm_form_input(APP_Z_SUBMIT, 'btnDesabo', 'Se désabonner');
				$zoneBoutonAbo=lsvm_form_input(APP_Z_SUBMIT, 'btnAbo', 'S\'abonner');
				$desabo=lsvm_form_input(APP_Z_HIDDEN, 'desAbo', $enr['utiID'], 40);
				$abo=lsvm_form_input(APP_Z_HIDDEN, 'abo', $enr['utiID'], 40);
				$saveRec=lsvm_form_input(APP_Z_HIDDEN, 'txtRecherche', $_POST['txtRecherche'], 40);
				$sqlSuiv="SELECT suiIDSuivi, suiIDSuiveur
				FROM suivi
				WHERE suiIDSuivi = '$utiID'
				AND suiIDSuiveur = '$id'";
				$resultSuiv=mysqli_query($lsvm_db_req,$sqlSuiv) or fd_bd_erreur($sqlSuiv);
				$enrSuiv=mysqli_fetch_assoc($resultSuiv);
				$sqlSuiveur="SELECT suiIDSuivi, suiIDSuiveur
				FROM suivi
				WHERE suiIDSuivi = '$id'
				AND suiIDSuiveur = '$utiID'";
				$resultSuiveur=mysqli_query($lsvm_db_req,$sqlSuiveur) or fd_bd_erreur($sqlSuiveur);
				$enrSuiveur=mysqli_fetch_assoc($resultSuiveur);
				$idSuiveur=$enrSuiveur['suiIDSuiveur'];
				if ($i==0){
					$recherche.= '<li class="resRecherche1">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
					$i=1;
				}elseif($i==1){
					$recherche.= '<li class="resRecherche2">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
					$i=0;
				}
				if($idSuiveur==$utiID){
					$recherche.= ' [Abonné à votre agenda]';				
				}
				if ($id!=$utiID){
					if($enrSuiv['suiIDSuivi']==$enr['utiID']){
						$recherche.= '<span class="btnAbo"><form method="POST" action="./recherche.php">'.$desabo.$saveRec.$zoneBoutonDesabo;
					}else{
						$recherche.= '<span class="btnAbo"><form method="POST" action="./recherche.php">'.$abo.$saveRec.$zoneBoutonAbo;
					}
				}
				$recherche.= '</span></form></li>';
			}
			$recherche.= '</ul>';
		}
		return $recherche;
	}
	$id=$_SESSION['id'];
	$lsvm_db_req=lsvm_db_connexion();
	//Abonne l'utilisateur à un autre
	if (isset($_POST['btnAbo'])) {
		$utiAbo=$_POST['abo'];
		$sqlAbo = "INSERT INTO suivi (suiIDSuiveur, suiIDSuivi)
			VALUES ('$id','$utiAbo')";
		$resultAbo = mysqli_query($lsvm_db_req,$sqlAbo) or fd_bd_erreur($lsvm_db_req);
	}
	//Désabonne l'utilisateur à un autre
	if (isset($_POST['btnDesabo'])) {
		$utiDesabo=$_POST['desAbo'];
		$sqlDesabo = "DELETE FROM suivi
			WHERE suiIDSuiveur = '$id'
			AND suiIDSuivi = '$utiDesabo'";
		$resultDesabo = mysqli_query($lsvm_db_req,$sqlDesabo) or fd_bd_erreur($lsvm_db_req);
	}
	//Initialise les variables et vérifie si une recherche a déjà été lancé. Sinon effectue une recherche.
	if (!isset($_POST['txtRecherche'])){
		$_POST['txtRecherche'] = '';
		$recherche='';
	}else{
		$recherche=lsvml_Recherche();
	}
	//Formulaire de recherche
	$zoneRecherche=lsvm_form_input(APP_Z_SEARCH, 'txtRecherche',$_POST['txtRecherche'], '40');
	$zoneBoutonRecherche=lsvm_form_input(APP_Z_SUBMIT, 'btnRechercher', 'Rechercher');
	echo '<section id="bcCentreRecherche"><form method="POST" action="./recherche.php">';
	echo '<p class="zoneForm">Entrez le critère de recherche : ',$zoneRecherche,' ',$zoneBoutonRecherche,'</p></form></br>';
	//Résultats de recherche
	echo $recherche;
	echo '</section></section>';
lsvm_html_pied();
?>