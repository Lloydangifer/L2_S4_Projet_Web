<?php
/** @file
 * Page de gestion des paramètres de l'utilisateur courant de l'application 24sur7
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 * @author : Sammy Loudiyi - sammy.loudiyi@edu.univ-fcomte.fr
 *
 */
include('bibli_24sur7.php');
ob_start();
session_start();
lsvm_verifie_session();
$lsvm_db_req=lsvm_db_connexion();
lsvm_html_head('24sur7 | Paramètres');
lsvm_html_bandeau(APP_PAGE_PARAMETRES);
echo'<section id="bcContenu">',
	'<form method=POST action="parametres.php">',
	'<h2>Informations sur votre compte</h2><hr>',
	'<label>Nom</label><input type="text" name="nom" required><br>',
	'<label>Email</label><input type="text" name="email" required><br>',
	'<label>Mot de passe</label><input type="password" name="mdp"><br>',
	'<label>Retapez le mot de passe</label><input type="password" name="verifmdp"><br>',
	'<input type="submit" name="btnEnvoiInfo" value="Mettre à jour"><input type="reset" name="btnAnnuleInfo" value="Annuler"><br>',
	'</form><br>',
	'<form method=POST action="rendezvous.php">',
	'<h2>Options d\'affichage du calendrier</h2><hr>',
	'<label>Jours affichés</label><input type="checkbox" name="lundi" value="lundi"><label>Lundi</label><input type="checkbox" name="mardi" value="mardi"><label>Mardi</label><input type="checkbox" name="mercredi" value="mercredi"><label>Mercredi</label><input type="checkbox" name="jeudi" value="jeudi"><label>Jeudi</label><input type="checkbox" name="vendredi" value="vendredi"><label>Vendredi</label><input type="checkbox" name="samedi" value="samedi"><label>Samedi</label><input type="checkbox" name="dimanche" value="dimanche"><label>Dimanche</label><br>',
	'<label>Heure minimale</label><input type="number" name="heuremin" min="0" max="23" value="8" id="horaire" required>:<input type="number" name="minutesmin" min="00" max="59" value="00" id="horaire" required><br>',
	'<label>Heure maximale</label><input type="number" name="heuremax" min="0" max="23" value="8" id="horaire" required>:<input type="number" name="minutesmax" min="00" max="59" value="00" id="horaire" required><br>',
	'<input type="submit" name="btnEnvoiOptions" value="Mettre à jour"><input type="reset" name="btnAnnuleOptions" value="Annuler">',
	'</form>',
	'<h2>Vos catégories</h2><hr>',
	'<label>Nom</label><input type="text" name="nomcat"> <label>Fond</label><input type="text" name="fondcat"> <label>Bordure</label><input type="text" name="bordcat"> <input type="checkbox" name="public" value="public"><label>Public</label><input type="image" src="../images/disquette.png" alt="svg"><input type="image" src="../images/supprimer.png" alt="suppr"><br>',
	'<h3>Nouvelle catégorie:</h3>',
	'<label>Nom</label><input type="text" name="nomnewcat"> <label>Fond</label><input type="text" name="fondnewcat"> <label>Bordure</label><input type="text" name="bordnewcat"> <input type="checkbox" name="public" value="public"><label>Public</label><input type=submit name="btnajout" value="Ajouter"><br>',
	'</section>';
lsvm_html_pied();
?>
