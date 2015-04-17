<?php include('bibli_24sur7.php');
lsvm_html_head('24sur7 | Agenda');
lsvm_html_bandeau(APP_PAGE_RECHERCHE);
	echo '<section id="bcContenu">';
	session_start();
	lsvm_verifie_session();
	if (!isset($_POST['txtRecherche'])){
		$_POST['txtRecherche'] = '';
	}
	echo '<section id="bcCentreRecherche">
	<form method="POST" action="../php/recherche.php">';
	$zoneRecherche=lsvm_form_input(APP_Z_SEARCH, 'txtRecherche',$_POST['txtRecherche'], '40');
	$zoneBoutonRecherche=lsvm_form_input(APP_Z_SUBMIT, 'btnRechercher', 'Rechercher');
	echo '<p class="zoneForm">Entrez le critère de recherche : ',$zoneRecherche,' ',$zoneBoutonRecherche,'</p></form></br>';
	if(!empty($_POST['btnRechercher'])){
		$lsvm_db_req=lsvm_db_connexion();
		$txtRecherche = trim($_POST['txtRecherche']);
		$txtRecherche = mysqli_real_escape_string($lsvm_db_req, $txtRecherche);
		$sql="SELECT DISTINCT utiNom, utiMail
		FROM utilisateur
		WHERE utiNom LIKE '%{$txtRecherche}%' OR utiNom LIKE '%{$txtRecherche}%'";
		$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($lsvm_bd);
		$i=0;
		while ($enr=mysqli_fetch_assoc($result)){
			if ($i==0){
				echo '<ul style="background-color:#9AC5E7; text-align:left; padding : 10px 10px;">',strip_tags($enr['utiNom']),' - ',strip_tags($enr['utiMail']),'</ul>';
				$i=1;
			}elseif($i==1){
				echo '<ul style="background-color:#E5ECF6; text-align:left; padding : 10px 10px;">',strip_tags($enr['utiNom']),' - ',strip_tags($enr['utiMail']),'</ul>';
				$i=0;
			}
		}
	}
	echo '</section></section>';
lsvm_html_pied();
?>