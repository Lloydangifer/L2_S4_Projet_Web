<?php
include('bibli_24sur7.php');
function lsvml_nouvelle_saisie(){
	echo   '<p>Nouvelle saisie</p>',
        '<hr>',
        '<p>Libellé:</p>',
        '<p>Date:<select name="date"><option value=1>1</option><option value=2>2</option></select></p>',
        '<p>Catégorie<p>',
        '<p>Horaire Début</p>',
        '<p>Horaire Fin</p>',
        '<p>ou</p>';
}
lsvm_html_head('24sur7 | Rendez-Vous');
lsvm_html_bandeau('RDV');
echo '<section id="bcContenu">',
		'<aside id="bcGauche">';
session_start();
lsvm_verifie_session();
$date=getdate();
$day=$date["mday"];
$month=$date["mon"];
$year=$date["year"];
lsvm_html_calendrier($day, $month, $year);
echo		'<section id="categories">',
				'Ici : bloc catégories pour afficher les catégories de rendez-vous',
			'</section>',
		'</aside>',
		'<section id="bcCentre">',
    lsvml_nouvelle_saisie();
	echo	'</section>',
	'</section>';
lsvm_html_pied();
?>