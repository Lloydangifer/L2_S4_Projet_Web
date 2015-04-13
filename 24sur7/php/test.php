<?php include 'bibli_24sur7.php';
	//Affichage de l'entête de la page
	lsvm_html_head('24sur7 | Accueil', '-');
	//Connexion à la base de données
	$lsvm_db_req=lsvm_db_connexion();
	//requête de la base de donnée
	$sql='SELECT *
		FROM categorie';
	//Stockage du résultat de la requête, ou affichage de l'erreur si il y a
	$result=mysqli_query($lsvm_db_req,$sql) or fd_bd_erreur($lsvm_bd);
	//Variable servant pour l'affichage du nom de l'utilisateur
	$i=0;
	while ($enr=mysqli_fetch_assoc($result)){
		//Affichage du nom de l'utilisateur
			echo $enr['catID']," ",$enr['catNom']," ",$enr['catCouleurFond']," ",$enr['catCouleurBordure']," ",$enr['catIDUtilisateur']," ",$enr['catPublic'],"</br>";
	}
?>