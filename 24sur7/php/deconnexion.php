<?php
/** @file
 * Page de déconnexion de l'application 24sur7
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 *
 */
include('bibli_24sur7.php');

session_start();
ls_verifie_session();
$_SESSION = array();
session_destroy();
header('refresh:3; url=./inscription.php');

?>