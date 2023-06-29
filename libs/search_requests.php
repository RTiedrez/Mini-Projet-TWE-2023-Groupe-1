<?php
	// Mini projet TWE 2023 - Groupe 1
	// Fichier réalisé par Jules Dumezy

	// Récupération de la session
	session_start();

	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");

	// Récupération des variables
	$action = $_POST["action"];
	$name = $_POST["name"];
	
	// Récupération de l'id du coach
	$idCoach = $_SESSION["idUser"];

	// Si une liste est demandée
	if ($action == "list") {

		// Création de la requête
		$SQL = "SELECT nomUser FROM v_requests WHERE idCoach = $idCoach";

		if ($name != "") {
			$SQL .= " AND nomUser LIKE \"$name%\"";
		}
		
		// Exécution de la requête
		$result = parcoursSel(SQLSelect($SQL), "nomUser");
		
		// Affichage du résultat
		echo showEntry($result, "request");
	}

	// Si une demande doit être acceptée
	if ($action == "accept") {
		
		// Récupération de l'id de l'utilisateur
		$SQL = "SELECT id FROM users WHERE login = '$name'";
		$id = SQLGetChamp($SQL);
		
		// Ajout du coach à l'utilisateur
		$SQL = "UPDATE users SET idCoach = $idCoach";
		//$SQL .= $_SESSION[];
		$SQL .= " WHERE id = '$id'";
		SQLUpdate($SQL);
		
		// Suppression de la demande
		$SQL = "DELETE FROM requests WHERE idUser = $id AND idCoach = $idCoach";
		SQLDelete($SQL);
	}

	// Si une demande doit être refusée
	if ($action == "decline") {
		
		// Récupération de l'id de l'utilisateur
		$SQL = "SELECT id FROM users WHERE login = '$name'";
		$id = SQLGetChamp($SQL);
		
		// Suppression de la demande
		$SQL = "DELETE FROM requests WHERE idUser = $id AND idCoach = $idCoach";		
		SQLDelete($SQL);
	}

?>

