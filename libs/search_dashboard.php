<?php

	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");

	// Récupération des variables
	$name = $_POST['name'];

	// Création de la requête
	if ($name == "") {
		$SQL = "SELECT login FROM users";
	}
	else {
		$SQL = "SELECT login FROM users WHERE login LIKE \"$name%\"";
	}

	// Exécution de la requête
	$result = parcoursSel(SQLSelect($SQL), "login");

	// Affichage du résultat
	echo showEntry($result, "dashboard");

?>

