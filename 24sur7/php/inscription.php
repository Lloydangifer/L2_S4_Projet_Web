<?php include 'bibli_24sur7.php';
	function  lsl_add_utilisateur(){
		$errs = array();
		//Erreur Nom Utilisateur
		if(isset($_POST['txtNom'])){
			$txtNom = trim($_POST['txtNom']);
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
		$ls_db_req=ls_db_connexion();
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
				session_start();
				$_SESSION['nom']=$txtNom;
				$_SESSION['id']=$enr['utiID'];
			}
			header('Location:./agenda.php');
			exit();
		}
		return $errs;
	}	
	ls_html_head('Application 24sur7|Inscription', '../styles/style.css');
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
		$zoneNom=ls_form_input(APP_Z_TEXT, 'txtNom',$_POST['txtNom'], '40');
		$zoneMail=ls_form_input(APP_Z_TEXT, 'txtMail',$_POST['txtMail'],'40');
		$zonePasse=ls_form_input(APP_Z_PASS, 'txtPasse',$_POST['txtPasse'],'20');
		$zonePasseVerif=ls_form_input(APP_Z_PASS, 'txtVerif',$_POST['txtVerif'],'20');
		$zoneBoutonVal=ls_form_input(APP_Z_SUBMIT, 'btnValider', 'S\'inscrire');
		$zoneBoutonAnnul=ls_form_input(APP_Z_RESET, 'btnAnnuler', 'Annuler');
		echo '<p class="zoneForm">Nom ',$zoneNom,'</br></p>
		<p class="zoneForm">Email ',$zoneMail,'</br></p>
		<p class="zoneForm">Mot de Passe ',$zonePasse,'</br></p>
		<p class="zoneForm">Retapez le mot de passe ',$zonePasseVerif,'</br></p></section>
		<p class="zoneForm">',$zoneBoutonVal,' ',$zoneBoutonAnnul,'</p></form>
		<p>D&eacute;j&agrave; inscrit ? <a href="./identification.php">Identifiez-vous !</a></p>
		<p>Vous h&eacute;sitez à vous inscrire ? Laissez-vous séduire par <a href="../html/presentation.html">une pr&eacute;sentaion</a> des possibilit&eacute;s de 24sur7</p>
		</section>';
	ls_html_pied();
?>