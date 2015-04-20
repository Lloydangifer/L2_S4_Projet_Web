<?php 
/** @file
 * Page de d'identification de l'application 24sur7
 *
 * Connecte l'utilisateur à l'application
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 * @author : Sammy Loudiyi - sammy.loudiyi@edu.univ-fcomte.fr
 *
 */
include ('bibli_24sur7.php');
/**
 * Fonction de login
 *
 * Connecte l'utilisateur et ouvre une session. Renvoie sur Agenda.php. Pas de paramètre
 */
function  lsvml_login_utilisateur(){
	//Se connecte à la base de donnée
	$lsvm_db_req=lsvm_db_connexion();
	//Créer un tableau d'erreur. Vérifie les différentes erreurs possibles.
	$errs = array();
		if(isset($_POST['txtMail'])){
			$txtMail = trim($_POST['txtMail']);
			$txtMail = mysqli_real_escape_string($lsvm_db_req, $txtMail);
		}
		else{
			$txtMail = NULL;
		}
		if ($txtMail==NULL){
			$errs['txtMail'] = 'L\'adresse mail est obligatoire';
		}else{
			if(isset($_POST['txtPasse'])){
				$txtPass = trim($_POST['txtPasse']);
				$txtPass = mysqli_real_escape_string($lsvm_db_req, $txtPass);
			}
			else{
				$txtPass = NULL;
			}
			if ($txtPass==NULL){
				$errs['txtPass'] = 'Le mot de passe est obligatoire';
			}
			$sql="SELECT*
			FROM utilisateur
			WHERE utiMail='$txtMail'";
			$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($sql);
			$num=mysqli_num_rows($result);
			if($num==0){ 	
				$errs['txtMail'] = 'Cette adresse mail n\'existe pas';
			}else{
				$pass=md5($txtPass);
				if($enr=mysqli_fetch_assoc($result)){
					$passUti=$enr['utiPasse'];
				}
				if(strcmp($pass,$passUti)!=0){
					$errs['badLogin'] = 'Mauvais mot de passe';
				}
			}
		}
		//S'il n'y a pas d'erreur, ouvre une session et renvoie sur agenda.php
		if(count($errs)==0){
		$sql="SELECT *
			FROM utilisateur
			WHERE utiMail='$txtMail'";
			$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($sql);
			if($enr=mysqli_fetch_assoc($result)){	
				$ID=$enr['utiID'];
				$nom=$enr['utiNom'];
				session_start();
				$_SESSION['nom']=$nom;
				$_SESSION['id']=$ID;
			}
			header('Location:./agenda.php');
			exit();
		}
		return $errs;
	}	
	//Fonction d'en-tête
	lsvm_html_head('Application 24sur7|Inscription', '../css/style.css');
	//Fonction du bandeau
	lsvm_html_bandeau('none');
	echo '<section id="bcContenu">';
	//Affichage des erreurs
	if(!empty($_POST['btnValider'])){
		$errs=lsvml_login_utilisateur();
		if (count($errs)!=0){
			echo '<p><strong>Les erreurs suivantes ont &eacutet&eacute d&eacutetect&eacutees</strong><br>';
			//Affichage erreur
			foreach($errs as $nomZone=>$valeur ){
				if (isset($errs['$nomZone'])){
					echo $valeur;
				}
			echo $valeur,"<br>";
			}	
			echo '</p>';
		}		
	}else{
		//Initialisation des variables
		$_POST['txtMail']="";
		$_POST['txtPasse']="";
	}
	//Affichage de la page et du formulaire de connection
	echo '<p>Pour vous connecter, veuillez vous identifiez.</p>
		<section id="bcCentreIdentification">
		<form method="POST" action="../php/identification.php">';
	$zoneMail=lsvm_form_input(APP_Z_TEXT, 'txtMail',$_POST['txtMail'],'40');
	$zonePasse=lsvm_form_input(APP_Z_PASS, 'txtPasse',$_POST['txtPasse'],'20');
	$zoneBoutonVal=lsvm_form_input(APP_Z_SUBMIT, 'btnValider', 'S\'identifier');
	$zoneBoutonAnnul=lsvm_form_input(APP_Z_RESET, 'btnAnnuler', 'Annuler');
	echo '<p class="zoneForm">Email ',$zoneMail,'</br></p>
		<p class="zoneForm">Mot de Passe ',$zonePasse,'</br></p></section>
		<p class="zoneForm">',$zoneBoutonVal,' ',$zoneBoutonAnnul,'</p>
		<p>Pas encore de compte ? <a href="./inscription.php">inscrivez-vous</a> sans plus tarder !</p>
		<p>Vous h&eacute;sitez à vous inscrire ? Laissez-vous séduire par <a href="../html/presentation.html">une pr&eacute;sentaion</a> des possibilit&eacute;s de 24sur7</p>
		</section>';
	lsvm_html_pied();
?>