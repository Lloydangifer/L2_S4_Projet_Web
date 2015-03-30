<?php
/** @file
 * Page de déconnexion de l'appliation 24sur7
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 *
 */

session_start();
fd_verifie_session();
$_SESSION = array();
session_destroy();
fd_redirige_("inscription.php");

?>