<?php 
include('bibli_24sur7.php');
	function  lsvml_add_utilisateur(){
		$errs = array();
		$lsvm_db_req=ls_db_connexion();
		//Erreur Nom Utilisateur
		if(isset($_POST['txtNom'])){
			$txtNom = trim($_POST['txtNom']);
			$txtNom = mysqli_real_escape_string($lsvm_db_req, $txtNom);
		}
		else{
			$txtNom = NULL;
		}
		$lenNom = strlen($txtNom);
	
		if ($txtNom==NULL){
			$errs['txtNom'] = 'Le nom doit &ecirc;tre renseign&eacute;';
		} elseif ($lenNom < 4 || $lenNom > 30) {
			$errs['txtNom'] = 'Le nom doit avoir de 4 &agrave 30 caract&egraveres';

		}
		//Erreur Mail
		if(isset($_POST['txtMail'])){
			$txtMail = trim($_POST['txtMail']);
			$txtMail = mysqli_real_escape_string($ls_db_req, $txtMail);
		}
		else{
			$txtMail = NULL;
		}
		$carObl1 = '@';
		$carObl2 = '.';
		$pres1 = strpos($txtMail, $carObl1);
		$pres2 = strpos($txtMail, $carObl2);
		if ($txtMail==NULL){
			$errs['txtMail'] = 'L\'adresse mail est obligatoire';
		}
		elseif ($pres1===FALSE||$pres2===FALSE){
			$errs['txtMail'] = 'L\'adresse mail n\'est pas valide';
		}
		$sql="SELECT*
		FROM utilisateur
		WHERE utiMail='$txtMail'";
		$result=mysqli_query($ls_db_req,$sql) or fd_bd_erreur($ls_bd);
		$num=mysqli_num_rows($result);
		if($num!=0){ 	
			$errs['txtMail'] = 'Cette adresse mail est d&eacutej&agrave inscrite';
		}
		//Erreur Mot de passe
		if(isset($_POST['txtPasse'])){
			$txtPass = trim($_POST['txtPasse']);
			$txtPass = mysqli_real_escape_string($ls_db_req, $txtPass);
		}
		else{
			$txtPass = NULL;
		}
		$lenPass = strlen($txtPass);
		if ($txtPass==NULL){
			$errs['txtPass'] = 'Le mot de passe est obligatoire';
		} elseif ($lenPass < 4 || $lenPass > 20) {
			$errs['txtPasse'] = 'Le mot de passe doit avoir de 4 &agrave 20 caract&egraveres';
		}
		//Erreur Vérification mot de passe
		if(isset($_POST['txtVerif'])){
			$txtVerif = trim($_POST['txtVerif']);
			$txtVerif = mysqli_real_escape_string($ls_db_req, $txtVerif);
		}
		else{
			$txtVerif = NULL;
		}
		$cmpPass = strcmp($txtPass,$txtVerif);
		if ($cmpPass!==0){
			$errs['txtVerif'] = 'Le mot de passe est diff&eacuterent dans les 2 zones';
		}
		//Ajout utilisateur
		if(count($errs)==0){
			$pass=md5($txtPass);
			$date_j_act=date('j',time());
			$date_m_act=date('n',time());
			$date_a_act=date('Y',time());
			if (strlen($date_m_act)==1){
				$date_m_act='0'.$date_m_act;
			}
			$date=$date_a_act.$date_m_act.$date_j_act;
			$sqlAjout = "INSERT INTO utilisateur (utiNom, utiMail, utiPasse, utiDateInscription, utiJours, utiHeureMin, utiHeureMax)
			VALUES('$txtNom', '$txtMail', '$pass', '$date', 127, 6, 22)";
			$result=mysqli_query($ls_db_req,$sqlAjout) or fd_bd_erreur($ls_bd);
			$sql="SELECT utiID
			FROM utilisateur
			WHERE utiMail='$txtMail'";
			$result=mysqli_query($ls_db_req,$sql) or fd_bd_erreur($ls_bd);
			if($enr=mysqli_fetch_assoc($result)){	
				$ID=$enr['utiID'];
				session_start();
				$_SESSION['nom']=$txtNom;
				$_SESSION['id']=$ID;
			}
			$sqlAjoutCat = "INSERT INTO categorie (catNom, catCouleurFond, catCouleurBordure, catIDUtilisateur, catPublic)
			VALUES('D&eacute;faut', 'FFFFFF', '000000', '$ID', 0)";
			$resultCat=mysqli_query($ls_db_req,$sqlAjoutCat) or fd_bd_erreur($ls_bd);
			header('Location:./agenda.php');
			exit();
		}
		return $errs;
	}	
	ls_html_head('Application 24sur7|Inscription', '../css/style.css');
	ls_html_bandeau('none');
	echo '<section id="bcContenu">';
	if(!empty($_POST['btnValider'])){
		$errs=lsl_add_utilisateur();
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
		$_POST['txtNom']="";
		$_POST['txtMail']="";
		$_POST['txtPasse']="";
		$_POST['txtVerif']="";
	}
	echo '<p>Pour vous inscrire &agrave; <strong>24sur7</strong>, veuillez remplir le formulaire ci-dessous.</p>
		<section id="bcCentreInscription">
		<form method="POST" action="../php/inscription.php">';
		$zoneNom=lsvm_form_input(APP_Z_TEXT, 'txtNom',$_POST['txtNom'], '40');
		$zoneMail=lsvm_form_input(APP_Z_TEXT, 'txtMail',$_POST['txtMail'],'40');
		$zonePasse=lsvm_form_input(APP_Z_PASS, 'txtPasse',$_POST['txtPasse'],'20');
		$zonePasseVerif=lsvm_form_input(APP_Z_PASS, 'txtVerif',$_POST['txtVerif'],'20');
		$zoneBoutonVal=lsvm_form_input(APP_Z_SUBMIT, 'btnValider', 'S\'inscrire');
		$zoneBoutonAnnul=lsvm_form_input(APP_Z_RESET, 'btnAnnuler', 'Annuler');
		echo '<p class="zoneForm">Nom ',$zoneNom,'</br></p>
		<p class="zoneForm">Email ',$zoneMail,'</br></p>
		<p class="zoneForm">Mot de Passe ',$zonePasse,'</br></p>
		<p class="zoneForm">Retapez le mot de passe ',$zonePasseVerif,'</br></p></section>
		<p class="zoneForm">',$zoneBoutonVal,' ',$zoneBoutonAnnul,'</p></form>
		<p>D&eacute;j&agrave; inscrit ? <a href="./identification.php">Identifiez-vous !</a></p>
		<p>Vous h&eacute;sitez à vous inscrire ? Laissez-vous séduire par <a href="../html/presentation.html">une pr&eacute;sentaion</a> des possibilit&eacute;s de 24sur7</p>
		</section>';
	lsvm_html_pied();
?>