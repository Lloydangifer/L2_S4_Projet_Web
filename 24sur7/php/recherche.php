<?php include('bibli_24sur7.php');
lsvm_html_head('24sur7 | Agenda');
lsvm_html_bandeau(APP_PAGE_RECHERCHE);
	echo '<section id="bcContenu">';
	session_start();
	lsvm_verifie_session();
		if(!empty($_POST['btnRechercher'])){
			$lsvm_db_req=lsvm_db_connexion();
			$txtRecherche = trim($_POST['txtRecherche']);
			$txtRecherche = mysqli_real_escape_string($lsvm_db_req, $txtRecherche);
			$sql="SELECT utiNom, utiMail
			FROM utilisateur
			WHERE CONCAT_WS(utiNom,utiMail) LIKE '%{$txtRecherche}%'";
			$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($lsvm_bd);
			while ($enr=mysqli_fetch_assoc($result)){
				echo strip_tags($enr['utiNom']),' ',strip_tags($enr['utiMail']),'</br>';
			}
		}else{
			$_POST['txtRecherche']="";
		}
	echo '<section id="bcCentreRecherche">
		<form method="POST" action="../php/recherche.php">';
	$zoneRecherche=lsvm_form_input(APP_Z_SEARCH, 'txtRecherche',$_POST['txtRecherche'], '40');
	$zoneBoutonRecherche=lsvm_form_input(APP_Z_SUBMIT, 'btnRechercher', 'Rechercher');
	echo '<p class="zoneForm">Entrez le critère de recherche : ',$zoneRecherche,' ',$zoneBoutonRecherche,'</p></form>';
	echo '</section></section>';
lsvm_html_pied();
?>