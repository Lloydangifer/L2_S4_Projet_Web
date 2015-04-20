<?php
/** @file
 * Page d'abonnement de l'application 24sur7
 *
 * Affiche les utilisateur auxquels l'utilisateur actuelle et abonné
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 * @author : Sammy Loudiyi - sammy.loudiyi@edu.univ-fcomte.fr
 *
 */  
include('bibli_24sur7.php');
//Fonction d'en-tête
lsvm_html_head('24sur7 | Agenda');
//Fonction du bandeau
lsvm_html_bandeau(APP_PAGE_ABONNEMENTS);
echo '<section id="bcContenu">';
//Ouverture et vérification de session
session_start();
lsvm_verifie_session();
	/**
	* Fonction de recherche
	*
	* Recherche les utilisateurs auxquels l'utilisateur actuelle est abonné
	*/
function lsvml_Abonnement(){
	$lsvm_db_req=lsvm_db_connexion();
	$id=$_SESSION['id'];
	$sql = "SELECT 	utiNom, utiMail, utiID, suiIDSuivi
	FROM 	utilisateur INNER JOIN suivi
	ON suivi.suiIDSuivi=utilisateur.utiID
	WHERE suiIDSuiveur = '$id'
	ORDER BY utiNom";
	$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($sql);
	$i=0;
	$num=mysqli_num_rows($result);
	if ($num==0){
		$abonnement = '<p>Vous n\'êtes abonné à aucun utilisateurs.</p>';
	}else{
		$abonnement='<ul>';
		while ($enr=mysqli_fetch_assoc($result)){
			$utiID=$enr['utiID'];
			$zoneBoutonDesabo=lsvm_form_input(APP_Z_SUBMIT, 'btnDesabo', 'Se désabonner');
			$desabo=lsvm_form_input(APP_Z_HIDDEN, 'desAbo', $enr['utiID'], 40);
			$sqlSuiveur="SELECT suiIDSuivi, suiIDSuiveur
			FROM suivi
			WHERE suiIDSuivi = '$id'
			AND suiIDSuiveur = '$utiID'";
			$resultSuiveur=mysqli_query($lsvm_db_req,$sqlSuiveur) or fd_bd_erreur($sqlSuiveur);
			$enrSuiveur=mysqli_fetch_assoc($resultSuiveur);
			$idSuiveur=$enrSuiveur['suiIDSuiveur'];
			if ($i==0){
				$abonnement.= '<li class="resRecherche1">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
				$i=1;
			}elseif($i==1){
				$abonnement.= '<li class="resRecherche2">'.strip_tags($enr['utiNom']).' - '.strip_tags($enr['utiMail']);
				$i=0;
			}
			if($idSuiveur==$utiID){
				$abonnement.= ' [Abonné à votre agenda]';				
			}
			if ($id!=$utiID){
				$abonnement.= '<span class="btnAbo"><form method="POST" action="./abonnements.php">'.$desabo.$zoneBoutonDesabo;
			}
			$abonnement.= '</span></form></li>';
			}
			$abonnement.= '</ul>';
		}
		return $abonnement;
	}
	$id=$_SESSION['id'];
	$lsvm_db_req=lsvm_db_connexion();
	//Désabonne l'utilisateur à un autre
	if (isset($_POST['btnDesabo'])) {
		$utiDesabo=$_POST['desAbo'];
		$sqlDesabo = "DELETE FROM suivi
			WHERE suiIDSuiveur = '$id'
			AND suiIDSuivi = '$utiDesabo'";
		$resultDesabo = mysqli_query($lsvm_db_req,$sqlDesabo) or fd_bd_erreur($lsvm_db_req);
	}
		$abonnement=lsvml_Abonnement();
		echo '<section id="bcCentreRecherche">';
		//Affiche résultats.
		echo $abonnement;
echo '</section></section>';
lsvm_html_pied();
?>