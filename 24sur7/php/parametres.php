<?php include('bibli_24sur7.php');
lsvm_html_head('24sur7 | Agenda');
lsvm_html_bandeau(APP_PAGE_PARAMETRES);
echo '<section id="bcContenu"><aside id="bcGauche">';
session_start();
lsvm_verifie_session();
echo '</aside></section>';
lsvm_html_pied();
?>