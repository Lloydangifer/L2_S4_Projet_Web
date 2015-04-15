<?php
/** @file
 * Page de déconnexion de l'application 24sur7
 *
 * @author : Virgil Manrique - virgil.manrique@edu.univ-fcomte.fr
 * @author : Sammy Loudiyi - sammy.loudiyi@edu.univ-fcomte.fr
 *
 */
include('bibli_24sur7.php');

session_start();
lsvm_verifie_session();
$_SESSION = array();
session_destroy();
header('location:./identification.php');

?>