<?php 
//Constante Onglet Agenda
	define('APP_PAGE_AGENDA', "Agenda.php");
	define('APP_PAGE_RECHERCHE', "Recherche.php");
	define('APP_PAGE_ABONNEMENTS', "Abonnements.php");
	define('APP_PAGE_PARAMETRES', "Parametres.php");
//Constante connexion Base de Données
	define ('APP_BD_URL', "localhost");
	define ('APP_BD_USER', "u_24sur7");
	define ('APP_BD_PASS', "p_24sur7");
	define ('APP_BD_NOM', "24sur7");
//Constante type de zone de saisie
	define ('APP_Z_TEXT', "text");
	define ('APP_Z_PASS', "password");
	define ('APP_Z_SUBMIT', "submit");
	define ('APP_Z_RESET', "reset");
	define ('APP_Z_SEARCH', "search");
	
/**
 * Fonction de l'en-tête de page
 *
 * Génère l'en-tête de page
 *
 * @param 	string $titre titre de la page
 * @param 	string $css chemin vers le fichier css(par défaut '../css/style.css'). Si paramètre = '-' : pas de feuille de style.
 */
	function lsvm_html_head($titre, $css = '../css/style.css'){
		if ($css!='-'){
				echo '<!DOCTYPE HTML>',
			'<html>',
			'<head>',
				'<meta charset="UTF-8">',
				'<title>', $titre ,'</title>',
				'<link rel="stylesheet" href="', $css ,'" type="text/css">',
				'<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
			'</head>',
			'<body>',
			'<main id="bcPage">';
		}
		else{
			echo '<!DOCTYPE HTML>',
			'<html>',
			'<head>',
				'<meta charset="UTF-8">',
				'<title>', $titre ,'</title>',
				'<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
			'</head>',
			'<body>',
			'<main id="bcPage">';
		}
	}

/**
 * Fonction du bandeau de page
 *
 * Génère le bandeau de page, change l'onglet actif selon la constante rentrée
 *
 * @param 	constante $page constante indiquant l'onglet. Si 'null', pas d'onglet.
 */
	function lsvm_html_bandeau($page){
		echo '<header id="bcEntete">',		
				'<div id="bcLogo"></div>',
				'<nav id="bcOnglets">';
				if ($page!='none'){
					if ($page==APP_PAGE_AGENDA){
						echo'<h2>Agenda</h2>',
						'<a href="recherche.php">Recherche</a>',
						'<a href="abonnements.php">Abonnements</a>',
						'<a href="parametres.php">Param&egrave;tres</a>';
					}elseif ($page==APP_PAGE_RECHERCHE){
						echo'<a href="agenda.php">Agenda</a>',
						'<h2>Recherche</h2>',
						'<a href="abonnements.php">Abonnements</a>',
						'<a href="parametres.php">Param&egrave;tres</a>';
					}elseif ($page==APP_PAGE_ABONNEMENTS){
						echo'<a href="agenda.php">Agenda</a>',
						'<a href="recherche.php">Recherche</a>',
						'<h2>Abonnements</h2>',
						'<a href="parametres.php">Param&egrave;tres</a>';
					}elseif ($page==APP_PAGE_PARAMETRES){
						echo'<a href="agenda.php">Agenda</a>',
						'<a href="recherche.php">Recherche</a>',
						'<a href="abonnements.php">Abonnements</a>',
						'<h2>Param&egrave;tres</h2>';
					}
                    else{
                        echo'<a href="agenda.php">Agenda</a>',
						'<a href="recherche.php">Recherche</a>',
						'<a href="abonnements.php">Abonnements</a>',
						'<a href="parametres.php">Param&egrave;tres</a>';
                    }
				}
				echo'</nav>',
				'<a href="deconnexion.php" id="btnDeconnexion" title="Se d&eacute;connecter"></a>',
			'</header>';
	}

/**
 * Fonction du pied de page
 *
 * Génère le pied de page, pas de paramètre
 *
 */
	function lsvm_html_pied(){
		echo '</body>
		<footer id="bcPied">',
				'<a id="apropos" href="apropos.php">A propos</a>',
				'<a id="confident" href="confident.php">Confidentialit&eacute;</a>',
				'<a id="conditions" href="condition.php">Conditions</a>',
				'<p id="copyright">24sur7 &amp; Partners &copy; 2012</p>',
			'</footer>';
	}
/**
 * Fonction du calendrier
 * 
 * Vérifie si la date est correct 
 * (sinon renvoie le mois et l'année
 * actuelle avec le jour courant séléctionné),
 * calcule le nombre de jour dans le mois
 * et dans le mois précédant. Génère le calendrier
 * en prenant en compte les jours du mois d'avant 
 * et d'après.
 *
 * @param 	int $jour jour séléctionné (jour actuel si 0)
 * @param 	int $mois mois séléctionné (mois et année actuel si 0)
 * @param	int $annee année séléctionné (mois et année actuel si 0)
 */
	function lsvm_html_calendrier($jour = 0, $mois = 0, $annee = 0 /*, $next = 0, $prev = 0*/ ){
		if($annee<2012){
			$jour=date('j',time());
			$mois=date('n',time());
			$annee=date('Y',time());	
		}
		if(checkdate($mois,$jour,$annee)==FALSE){
			if(($mois!=0)&&($annee!=0)){
				$jour=date('j',time());
				$mois=date('n',time());
				$annee=date('Y',time());
			} elseif($mois==0){
				$mois=date('n',time());
				$annee=date('Y',time());
			} elseif($annee==0){
				$annee=date('Y',time());
				$annee=date('Y',time());
			}
		}
		/*$mois=$mois+$next-$prev;*/
		$jour_actuel = mktime(0, 0, 0, $mois, $jour, $annee);
		$jour_actuel_mprev = mktime(0, 0, 0, $mois-1, $jour, $annee);
		if ($jour>28){
			$jour_actuel_mprev = mktime(0, 0, 0, $mois-1, $jour-5, $annee);
		}
		$prem_jmois = mktime(0, 0, 0, $mois, 1, $annee);
		$mois_nom = array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
		$nb_jmois=date("t",	$jour_actuel);
		$nb_jmois_prev=date("t", $jour_actuel_mprev);
		$num_jour_mois=date('w',$prem_jmois);
		$jour_actuel=date('j',time());
		$semaine = date('W', mktime(0, 0, 0, $mois, $jour, $annee));
		if ($num_jour_mois==0){
			$num_jour_mois = 6;
		} else {
			$num_jour_mois=$num_jour_mois-1;
		}
		$last_jmois=mktime(0,0,0,$mois,$nb_jmois,$annee);
		$last_jmois=date('w',$last_jmois);
		$nb_case=0;
		echo '<section id="calendrier">',
			'<p>',
				'<a href="agenda.php?prev=1" class="flechegauche"><img src="../images/fleche_gauche.png" alt="picto fleche gauche"></a>',$mois_nom[$mois-1],' ',$annee,
				'<a href="agenda.php?next=1" class="flechedroite"><img src="../images/fleche_droite.png" alt="picto fleche droite"></a>',
			'</p>',
			'<table>',
				'<tr>',
					'<th>Lu</th><th>Ma</th><th>Me</th><th>Je</th><th>Ve</th><th>Sa</th><th>Di</th>',
				'</tr>',
				'<tr>';
				for($i=$nb_jmois_prev-$num_jour_mois+1;$i<=$nb_jmois_prev;$i++){
					echo '<td><a class="lienJourHorsMois" href="#">',$i,'</a></td>';
					$nb_case=$nb_case+1;
				}
				for ($i=1; $i<=$nb_jmois; $i++){
					if($nb_case%7==0){
						if (date('W', mktime(0, 0, 0, $mois, $i + 1, $annee)) == $semaine) {
							echo '</tr><tr class="semaineCourante">';
						}else{
							echo '</tr><tr>';
						}
					}
					if(($i==$jour_actuel)/*&&($next==0)&&($prev==0)*/){
						echo '<td class="aujourdHui"><a href="#">',$i,'</a></td>';
					} else {
						if($i==$jour){
							echo '<td class="jourCourant"><a href="#">',$i,'</a></td>';
						} else {
							echo '<td><a href="#">',$i,'</a></td>';
						}
					}
					$nb_case=$nb_case+1;
				}
				if ($last_jmois!=0){
					for($i=1;$i<=7-$last_jmois;$i++){
						echo '<td><a class="lienJourHorsMois" href="#">',$i,'</a></td>';
					}
				}			
		echo '</table>',
		'</section>';					
	}

	
	//____________________________________________________________________________
/**
 * Traitement erreur mysql, affichage et exit.
 *
 * @param string	$sql	Requête SQL ou message
 */
function fd_bd_erreur($sql) {
    $errNum = mysqli_errno($GLOBALS['bd']);
    $errTxt = mysqli_error($GLOBALS['bd']);
		
    // Collecte des informations facilitant le debugage
    $msg = '<h4>Erreur de requ&ecirc;te</h4>'
        ."<pre><b>Erreur mysql :</b> $errNum"
        ."<br> $errTxt"
	        ."<br><br><b>Requ&ecirc;te :</b><br> $sql"
        .'<br><br><b>Pile des appels de fonction</b>';

    // Récupération de la pile des appels de fonction
    $msg .= '<table border="1" cellspacing="0" cellpadding="2">'
                .'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
                .'<td>Fichier</td></tr>';
			
    // http://www.php.net/manual/fr/function.debug-backtrace.php
    $appels = debug_backtrace();
    for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
        $msg .= '<tr align="center"><td>'
                    .$appels[$i]['function'].'</td><td>'
                    .$appels[$i]['line'].'</td><td>'
                    .$appels[$i]['file'].'</td></tr>';
    }
	
    $msg .= '</table></pre>';

    fd_bd_erreurExit($msg);
}
//___________________________________________________________________
/**
 * Arrêt du script si erreur base de données.
 * Affichage d'un message d'erreur si on est en phase de
 * développement, sinon stockage dans un fichier log.
 *
 * @param string	$msg	Message affiché ou stocké.
 */
function fd_bd_erreurExit($msg) {
    ob_end_clean();		// Supression de tout ce qui a pu être déja généré
	
    // Si on est en phase de développement, on affiche le message
    if (APP_TEST) {
        echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
                'Erreur base de données</title></head><body>',
                $msg,
                '</body></html>';
        exit();
    }
		
    // Si on est en phase de production on stocke les
    // informations de débuggage dans un fichier d'erreurs
    // et on affiche un message sibyllin.
    $buffer = date('d/m/Y H:i:s')."\n$msg\n";
    error_log($buffer, 3, 'erreurs_bd.txt');
	
    // Génération d'une page spéciale erreur
    fd_html_head('24sur7');
		
    echo '<h1>24sur7 est overbook&eacute;</h1>',
        '<div id="bcDescription">',
            '<h3 class="gauche">Merci de r&eacute;essayez dans un moment</h3>',
        '</div>';
	
    fd_html_pied();
    exit();
}

/**
 * Fonction de connexion à la base de donnée
 *
 * Fait la connexion à la base de donnée et fait appel à la fonction d'erreur si il y a un problème
 *
 * @param 	constante 'APP_BD_NOM' Nom de la base de données
 * @param   constante 'APP_BD_URL' Adresse de la base de données
 * @param   constante 'APP_BD_USER' login de l'utilisateur
 * @param   constante 'APP_BD_PASS' mot de passe de l'utilisateur
 */
function lsvm_db_connexion(){
		$lsvm_bd=mysqli_connect(APP_BD_URL,APP_BD_USER,APP_BD_PASS,APP_BD_NOM);
	if ($lsvm_bd===FALSE){
		fd_bd_erreur($lsvm_bd);
	}
	else{
		return $lsvm_bd;
		}
	}
	
/**
 * Fonction de l'affichage de la date
 *
 * Génère l'affichage de la date suivant les informations prises sur la base de données
 * Converti le mois chiffré en chaîne de caractère
 *
 * @param int $jour Jour de la date
 * @param int $annee Annee de la date
 * @param int $mois Mois (chiffré) de la date
 * @param string $mois_nom_bd conversion du mois chiffré en chaîne de caractère
 */
function lsvm_date_claire($amj){
		$jour=substr($amj,6,2);
		$annee=substr($amj,0,4);
		$mois=substr($amj,4,2);
		$mois_nom_bd = array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
		echo $jour,' ',$mois_nom_bd[$mois-1],' ',$annee;
	}
	
/**
 * Fonction de l'affichage de l'heure
 *
 * Génère l'affichage de l'heure suivant les informations prises sur la base de données
 * Gère l'affichage par rapport à la présence ou nom de minute, et si l'heure est comprise entre 0 et 9 ou 10 et 11. 
 *
 * @param int $leng longueur de l'heure donnée par la base de données
 * @param int $heure Heure
 * @param int $minute Minute
 */
function lsvm_heure_claire($h){
		$leng=strlen($h);
		if ($leng==4){
			$heure=substr($h,0,2);
			$minute=substr($h,2,2);
		}
		else{
			$heure=substr($h,0,1);
			$minute=substr($h,1,2);
		}
		if ($minute!=00){
			echo $heure,'h',$minute;
		}
		else{
			echo $heure,'h';
		}
	}
	
/**
 * Fonction de l'affichage du formulaire
 *
 * Affiche les lignes du formulaire une par une, avec les cases gauches (libélés) et droites (zone de saisie ou de séléction) de chaque ligne de saisie
 * 
 * @param string $gauche Libéllé de la zone de saisie ou de séléction
 * @param string $droite Code html de la zone de saisie ou de séléction
 */
function lsvm_form_ligne($gauche, $droite){
	echo '<tr><td>',$gauche,'</td><td>',$droite,'</td></tr>';
}	

/**
 * Fonction de génération du code html de la zone de saisie
 *
 * Génère le code html de la zone de saisie en fonction des paramètres
 * 
 * @param constante APP_Z_TEXT Zone de texte 
 * @param constante APP_Z_PASS Zone de mot de passe
 * @param constante APP_Z_SUBMIT Bouton de soumission
 * @param string $type Constante entrée
 * @param string $nom Nom de la zone 
 * @param string $value Valeur de la zone
 * @param int $size Taille de la zone 
 */
function lsvm_form_input($type, $name, $value, $size=0){
	if ($type==APP_Z_SUBMIT||$type==APP_Z_RESET){
		$input = '<input class="tailleBouton" type="'.$type.'" value="'.$value.'"name="'.$name.'" size="'.$size.'">';
		return $input;
	}elseif ($type==APP_Z_SEARCH){
		$input = '<input class="tailleZoneSaisieR" type="'.$type.'" value="'.$value.'"name="'.$name.'" size="'.$size.'">';
		return $input;
	}else{
		$input = '<input class="tailleZoneSaisie" type="'.$type.'" value="'.$value.'"name="'.$name.'" size="'.$size.'">';
		return $input;
	}
	
}

/**
 * Fonction de génération du code html de la zone de séléction de date
 *
 * Génère le code html de la zone de séléction de date en fonction des paramètres
 * 
 * @param string $nom Nom de la zone de séléction
 * @param int $jour Jour séléctionné par défaut (si valeur à 0, jour actuel)
 * @param int $mois Mois séléctionné par défaut (si valeur à 0, mois actuel)
 * @param int $annee Année séléctionné par défaut (si valeur à 0, année actuel)
 */	
function lsvm_form_date($nom, $jour=0, $mois=0, $annee=0){
	if ($jour==0){
		$jour=date('j',time());
	}
	if ($mois==0){
		$mois=date('n',time());
	}
	if ($annee==0){
		$annee=date('Y',time());
	}
	$anAct=date('Y',time());
	$anBorneMin=date('Y',time())-99;
	$i=1;
	$mois_nom = array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
	$date = '<select name="'.$nom.'_j">';
		for ($i=1;$i<=31;$i++){
			if($i==$jour){
				$date = $date.'<option value=\''.$i.'\' selected>'.$i.'</option>';
			}else{
				$date = $date.'<option value=\''.$i.'\'>'.$i.'</option>';
			}
		}
		$date = $date.'</select>';
	$date = $date.'<select name="'.$nom.'_m">';
		for ($i=1;$i<=12;$i++){
			if($i==$mois){
				$date = $date.'<option value=\''.$i.'\' selected>'.$mois_nom[$i-1].'</option>';
			}else{
				$date = $date.'<option value=\''.$i.'\'>'.$mois_nom[$i-1].'</option>';
			}
		}
		$date = $date.'</select>';
	$i=$anAct;
	$date = $date.'<select name="'.$nom.'_a">';
		while($i>$anBorneMin){
			if($i==$annee){
				$date = $date.'<option value=\''.$i.'\' selected>'.$i.'</option>';
			}else{
				$date = $date.'<option value=\''.$i.'\'>'.$i.'</option>';
			}
			$i--;
		}
		$date = $date.'</select>';
	return $date;
}

/**
 * Fonction de vérification de session
 *
 * Vérifie si une session est ouverte, et renvoie vers inscription.php si ce n'est pas le cas. Pas de paramètre.
 */	
function lsvm_verifie_session(){
	if(empty($_SESSION['id'])){
		echo 'Il  n\'y a aucun utilisateurs identifi&eacute</section>';
		lsvm_html_pied();
		header('refresh:3; url=./identification.php');
		exit();
	}
}
?>