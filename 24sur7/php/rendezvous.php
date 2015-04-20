<?php
include('bibli_24sur7.php');
function lsvml_modifier_rendezvous(){
	echo'<p><strong>Nouvelle saisie</strong></p>',
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
			'<label>Libellé: </label><input type="text" name="libelle"  required><br>',
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
ob_start();
session_start();
lsvm_verifie_session();
$lsvm_db_req=lsvm_db_connexion();
$date=getdate();
$jour=$date["mday"];
$mois=$date["mon"];
$annee=$date["year"];
lsvm_html_head('24sur7 | Rendez-Vous');
lsvm_html_bandeau('RDV');
echo '<section id="bcContenu">',
		'<aside id="bcGauche">';
lsvm_html_calendrier($jour, $mois, $annee);
echo	'<section id="categories">';
			lsvm_html_categories($_SESSION['nom'],$_SESSION['id'],$lsvm_db_req);
		echo'</section>',
		'</aside>',
		'<section id="bcCentre">'.
			(!empty($sqlparam)) ? lsvml_modifier_rendezvous():lsvml_nouveau_rendezvous().
		'</section>',
	'</section>';
lsvm_html_pied();
?>
