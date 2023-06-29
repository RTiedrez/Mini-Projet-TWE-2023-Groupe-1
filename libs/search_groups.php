<?php
	// Mini projet TWE 2023 - Groupe 1
	// Fichier réalisé par Jules Dumezy

	// Récupération de la session
	session_start();

	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");

	// Récupération de l'action
	$action = $_POST['action'];
	
	// Récupération de l'id du coach
	$idCoach = $_SESSION["idUser"];

	// Si une liste est demandée
	if ($action == "list") {

		// Création de la requête
		$SQL = "SELECT name FROM groupes WHERE idCoach = $idCoach";
		
		// Exécution de le requête
		$result = parcoursSel(SQLSelect($SQL), "name");
		
		// Affichage du résultat
		echo showEntry($result, "group");
	}

	// Si un groupe est demandé
	if ($action == "group") {

		// Récupération des variables
		$name = $_POST['name'];
		
		// Création de la requête
		$SQL = "SELECT login FROM v_user_group WHERE nomGroupe = \"$name\"";
		
		// Exécution de le requête
		$result = parcoursRs(SQLSelect($SQL));
		
		// Affichage du résultat
		echo showGroup($result);
	}

	// Si l'éditeur est demandé
	if ($action == "editor") {

		// Récupération des variables
		$name = $_POST['name'];
		
		// Si l'éditeur est chargé en mode nouveau groupe
		if ($name == "create-new-group") {
			// Le nom du groupe est vide
			$nameEdit = showNameEdit(false);
			
			// Tous les utilisateurs sont libres
			$SQL1 = "SELECT * FROM users WHERE isCoach = 0 AND idCoach = $idCoach";
			$freeUsers = showSortList(parcoursSel(SQLSelect($SQL1), "login"));
			
			// Aucun utilisateur est membre du groupe
			$groupUsers = showSortList(false);
		}
		
		// Si l'éditeur est chargé mode éditon d'un groupe
		else {
			// Le nom du groupe est celui passé en argument
			$nameEdit = showNameEdit($name);
			
			// Les utilisateurs libres sont listés
			$SQL1 = "SELECT u.login FROM users u LEFT JOIN v_user_group g
						ON u.id = g.idUser
						WHERE (g.idUser IS NULL or g.nomGroupe <> \"$name\") AND u.isCoach = 0 AND idCoach = $idCoach";
			$freeUsers = showSortList(parcoursSel(SQLSelect($SQL1), "login"));
			
			// Les membres du groupe sont listés
			$SQL2 = "SELECT login FROM v_user_group WHERE nomGroupe = \"$name\"";
			$groupUsers = showSortList(parcoursSel(SQLSelect($SQL2), "login"));
		}
		
		// On enregistre les résultats dans un tableau associatif
		$result = array("name-group" => $nameEdit,
						"free-users" => $freeUsers,
						"group-users" => $groupUsers);
		
		// Affichage du résultat
		echo json_encode($result);
	}

	// Si un groupe doit être modifié
	if ($action == "edit") {

		// Récupération des variables
		$name = $_POST['name'];
		$oName = $_POST['oName'];
		$users = $_POST['users'];
		
		// Récupération des id des utilisateurs
		$SQL = "SELECT id FROM groupes WHERE name = \"$oName\"";
		$id = SQLGetChamp($SQL);
		$idUsers = array();
		
		foreach($users as $u) {
			$SQL = "SELECT id FROM users WHERE login = \"$u\"";
			array_push($idUsers, SQLGetChamp($SQL));
		}
		
		// Mise à jour du nom du groupe
		if ($oName != $name) {
			$SQL = "UPDATE groupes SET name = \"$name\" WHERE id = $id";	
			SQLUpdate($SQL);
		}
		
		// Récupération des id des utilisateurs membres du groupe
		$SQL = "SELECT idUser FROM v_user_group WHERE idGroup = $id";
		$req = parcoursRS(SQLSelect($SQL));
		$oUsers = array();
		
		foreach($req as $o) {
			array_push($oUsers, $o["idUser"]);
		}
		
		// Ajout des nouveaux utilisateur
		$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ";
		foreach($idUsers as $u) {
			if (!(in_array($u, $oUsers))) {
				$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ($u,$id)";
				SQLInsert($SQL);
			}
		}
		
		// Retrait des utilisateurs qui ont été retirés
		foreach($oUsers as $o) {
			if (!(in_array($o, $idUsers))) {
				$SQL = "DELETE FROM user_group WHERE idUser = $o AND idGroup = $id";
				SQLDelete($SQL);
			}
		}
	}

	// Si un groupe doit être ajouté
	if ($action == "add") {

		// Récupération des variables
		$name = $_POST['name'];
		$users = $_POST['users'];
		
		// Réupération des id des utilisateurs
		$idUsers = array();
		
		foreach($users as $u) {
			$SQL = "SELECT id FROM users WHERE login = \"$u\"";
			array_push($idUsers, SQLGetChamp($SQL));
		}
		
		// Création du groupe
		$SQL = "INSERT INTO groupes (idCoach, name) VALUES ($idCoach, \"$name\")";
		$id = SQLInsert($SQL);
		
		// Ajout des utilisateurs
		$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ";
		foreach($idUsers as $u) {
			$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ($u,$id)";
			SQLInsert($SQL);
		}
	}

	// Si un groupe doit être supprimé
	if ($action == "delete") {

		// Récupération des variables
		$name = $_POST['name'];
		
		// Récupération de l'id du groupe
		$SQL = "SELECT id FROM groupes WHERE name = '$name'";
		$id = SQLGetChamp($SQL);
		
		// Suppresion du groupe
		$SQL = "DELETE FROM groupes WHERE id=$id";
		SQLDelete($SQL);
	}

?>

