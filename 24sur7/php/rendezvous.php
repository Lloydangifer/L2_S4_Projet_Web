<?php
include('bibli_24sur7.php');
function lsvml_nouvelle_saisie(){
	echo	'<p>Nouvelle saisie</p>',
			'<hr>',
			'<form method=POST action="rendezvous.php">',
			'<p>Libellé: <input type="text" name="libelle"></p>',
			'<p>Date:<input type="number" name="selDate_j" min="1" max="31" value="1" size="2" required>
					 <input type="number" name="selDate_m" min="1" max="12" value="1" required>
					 <input type="number" name="selDate_a" min="2015" value="2015" required></p>',
        '<p>Catégorie<p>',
        '<p>Horaire Début:  <input type="number" name="heuredeb" min="0" max="23" value="8" required>:
							<input type="number" name="minutesdeb" min="00" max="59" value="00" required></p>',
        '<p>Horaire Fin: <input type="number" name="heurefin" min="0" max="23" value="8" required>:
						 <input type="number" name="minutesfin" min="00" max="59" value="00" required></p>',
        '<p>Ou <input type="checkbox" name="journee" id="journee" value="entiere"><label for="journee"> Evénement sur une journée</label></p>',
        '<input type="submit" name="btnEnvoi" value="Ajouter"><input type="submit" name="btnAnnule" value="Annuler">',
        '<p><a href="javascript:history.back()">Retour à l\'agenda</a></p>',
        '</form>';
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
