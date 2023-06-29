<?php
	// Mini projet TWE 2023 - Groupe 1
	// Fichier réalisé par Jules Dumezy
	
	// Récupération de la session
	session_start();
	
	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");

	// Récupération des variables
	$name = $_POST['name'];
	
	// Récupération de l'id du coach
	$idCoach = $_SESSION["idUser"];

	// Création de la requête
	if ($name == "") {
		$SQL = "SELECT login FROM users WHERE idCoach = $idCoach";
	}
	else {
		$SQL = "SELECT login FROM users WHERE login LIKE \"$name%\"
											AND idCoach = $idCoach";
	}

	// Exécution de la requête
	$result = parcoursSel(SQLSelect($SQL), "login");

	// Affichage du résultat
	echo showEntry($result, "dashboard");

?>

