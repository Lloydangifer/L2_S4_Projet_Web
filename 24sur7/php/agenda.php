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
/*$next=0;
$prev=0;
if((isset($_GET['next'])&&($_GET['next']==1))){
			$next=$next+1;
			$prev=0;
		}elseif((isset($_GET['prev'])&&($_GET['prev']==1))){
			$prev=$prev+1;
			$next=0;
		}else{
			$prev=0;
			$next=0;
		}*/
ls_html_calendrier($day, $month, $year);
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