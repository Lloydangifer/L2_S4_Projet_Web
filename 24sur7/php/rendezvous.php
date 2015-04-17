<?php
include('bibli_24sur7.php');
function lsvml_modifier_rendezvous(){
	echo	'<p><strong>Nouvelle saisie</strong></p>',
			'<hr>',
			'<form method=POST action="rendezvous.php">',
			'<label>Libellé: </label><input type="text" name="libelle" required><br>',
			'<label>Date:</label><input type="number" name="selDate_j" min="1" max="31" value="1" size="2" id="jour" required>
					 <input type="number" name="selDate_m" min="1" max="12" value="1" size="2" id="jour" required>
					 <input type="number" name="selDate_a" min="2015" value="2015" size="2" id="annee" required><br>',
        '<label>Catégorie:</label><input type="number" required><br>',
        '<label>Horaire Début:</label>  <input type="number" name="heuredeb" min="0" max="23" value="8" id="horaire" required>:
							<input type="number" name="minutesdeb" min="00" max="59" value="00" id="horaire" required><br>',
        '<label>Horaire Fin: <input type="number" name="heurefin" min="0" max="23" value="8" id="horaire" required>:
						 <input type="number" name="minutesfin" min="00" max="59" value="00" id="horaire" required></label><br>',
        '<label>Ou </label><input type="checkbox" name="journee" id="journee" value="entiere"><label for="journee"> Evénement sur une journée</label><br>',
        '<input type="submit" name="btnEnvoi" value="Mettre à jour"><input type="reset" name="btnAnnule" value="Supprimer">',
        '<p><a href="javascript:history.back()">Retour à l\'agenda</a></p>',
        '</form>';
}
function lsvml_nouveau_rendezvous(){
	echo	'<p><strong>Nouvelle saisie</strong></p>',
			'<hr>',
			'<form method=POST action="rendezvous.php">',
			'<label>Libellé: </label><input type="text" name="libelle" required><br>',
			'<label>Date:</label><input type="number" name="selDate_j" min="1" max="31" value="1" size="2" id="jour" required>
					 <input type="number" name="selDate_m" min="1" max="12" value="1" size="2" id="jour" required>
					 <input type="number" name="selDate_a" min="2015" value="2015" size="2" id="annee" required><br>',
        '<label>Catégorie:</label><input type="number" required><br>',
        '<label>Horaire Début:</label>  <input type="number" name="heuredeb" min="0" max="23" value="8" id="horaire" required>:
							<input type="number" name="minutesdeb" min="00" max="59" value="00" id="horaire" required><br>',
        '<label>Horaire Fin: <input type="number" name="heurefin" min="0" max="23" value="8" id="horaire" required>:
						 <input type="number" name="minutesfin" min="00" max="59" value="00" id="horaire" required></label><br>',
        '<label>Ou </label><input type="checkbox" name="journee" id="journee" value="entiere"><label for="journee"> Evénement sur une journée</label><br>',
        '<input type="submit" name="btnEnvoi" value="Ajouter"><input type="reset" name="btnAnnule" value="Annuler">',
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
	if(!empty($sqlparam)){
		lsvml_modifier_rendezvous();
	}
	else{
		lsvml_nouveau_rendezvous();
	}
	echo	'</section>',
	'</section>';
lsvm_html_pied();
?>
