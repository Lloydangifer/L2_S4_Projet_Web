<?php include('bibli_24sur7.php');
ls_html_head('24sur7 | Agenda');
ls_html_bandeau(APP_PAGE_AGENDA);
echo '<section id="bcContenu">',
		'<aside id="bcGauche">';
session_start();
ls_verifie_session();
$date=getdate();
$day=$date["mday"];
$month=$date["mon"];
$year=$date["year"];
ls_html_calendrier('10','04','2015');
echo		'<section id="categories">',
				'Ici : bloc catégories pour afficher les catégories de rendez-vous',
			'</section>',
		'</aside>',
		'<section id="bcCentre">',
			'Ici : bloc avec le détail des rendez-vous de la semaine du 9 au 15 février 2015',
		'</section>',
	'</section>';
ls_html_pied();
?>