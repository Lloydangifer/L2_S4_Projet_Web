<?php 
include('bibli_24sur7.php');
session_start();
lsvm_verifie_session();
$lsvm_db_req=lsvm_db_connexion();
$date=getdate();
$jour=$date["mday"];
$mois=$date["mon"];
$annee=$date["year"];
$idSuivi=$_SESSION['id'];
lsvm_html_head('24sur7 | Agenda');
lsvm_html_bandeau(APP_PAGE_AGENDA);
echo '<section id="bcContenu">',
		'<aside id="bcGauche">';
			lsvm_html_calendrier($jour,$mois,$annee);
echo		'<section id="categories">';
				lsvm_html_categories($_SESSION['nom'],$_SESSION['id'],$lsvm_db_req);
echo		'</section>',
		'</aside>',
		'<section id="bcCentre">';
			lsvm_html_semainier($jour,$mois,$annee,$idSuivi,$lsvm_db_req);
echo	'</section>',
	'</section>';
lsvm_html_pied();
?>
