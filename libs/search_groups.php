<?php

include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("modele.php");

$action = $_POST['action'];

if ($action == "list") {
	$SQL = "SELECT name FROM groups"; // ajouter idCoach
		
	$result = parcoursRs(SQLSelect($SQL));

	echo showEntry($result, "group", "name");
}

if ($action == "group") {
	$name = $_POST['name'];

	$SQL = "SELECT login FROM v_user_group WHERE nomGroupe = \"$name\"";

	$result = parcoursRs(SQLSelect($SQL));

	echo showGroup($result);
}

if ($action == "editor") {
	$name = $_POST['name'];
	
	// Récupération partie gauche
	if ($name == "create-new-group") {
		$result1 = showNameEdit(false);
		$SQL1 = "SELECT * FROM users WHERE isCoach = 0";
		$result3 = showSortList(false);
	}
	else {
		$result1 = showNameEdit($name);
		$SQL1 = "SELECT u.login FROM users u LEFT JOIN v_user_group g ON u.id = g.idUser WHERE (g.idUser IS NULL or g.nomGroupe <> \"$name\") AND u.isCoach = 0"; // cette requète n'est pas bonne
		$SQL2 = "SELECT login FROM v_user_group WHERE nomGroupe = \"$name\"";
		$result3 = showSortList(parcoursSel(SQLSelect($SQL2), "login"));
	}
	
	$result2 = showSortList(parcoursSel(SQLSelect($SQL1), "login"));
	
	$result = array("nameGroup" => $result1, "freeUsers" => $result2, "groupUsers" => $result3);
	echo json_encode($result);
}

if ($action == "edit") {
	$name = $_POST['name'];
	$oName = $_POST['oName'];
	$users = $_POST['users'];
	
	// Réupération des ids
	$SQL = "SELECT id FROM groups WHERE name = \"$oName\"";
	$id = SQLGetChamp($SQL);
	$idUsers = array();
	
	foreach($users as $u) {
		$SQL = "SELECT id FROM users WHERE login = \"$u\"";
		array_push($idUsers, SQLGetChamp($SQL));
	}
	
	// Maj du nom
	if ($oName != $name) {
		$SQL = "UPDATE groups SET name = \"$name\" WHERE id = $id";	
		SQLUpdate($SQL);
	}
	
	// Maj des membres
	$SQL = "SELECT idUser FROM v_user_group WHERE idGroup = $id";
	$req = parcoursRS(SQLSelect($SQL));
	$oUsers = array();
	foreach($req as $o) {
		array_push($oUsers, $o["idUser"]);
	}
	
	// Ajout
	$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ";
	foreach($idUsers as $u) {
		if (!(in_array($u, $oUsers))) {
			$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ($u,$id)";
			SQLInsert($SQL);
		}
	}
	
	// Retrait
	foreach($oUsers as $o) {
		if (!(in_array($o, $idUsers))) {
			$SQL = "DELETE FROM user_group WHERE idUser = $o AND idGroup = $id";
			SQLDelete($SQL);
		}
	}
}

if ($action == "add") {
	$name = $_POST['name'];
	$users = $_POST['users'];
	
	// Réupération des ids
	$idUsers = array();
	
	foreach($users as $u) {
		$SQL = "SELECT id FROM users WHERE login = \"$u\"";
		array_push($idUsers, SQLGetChamp($SQL));
	}
	
	// Création
	$SQL = "INSERT INTO groups (idCoach, name) VALUES (1, \"$name\")"; //ajouter id coach	
	$id = SQLInsert($SQL);
	
	// Ajout
	$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ";
	foreach($idUsers as $u) {
		$SQL = "INSERT INTO user_group (idUser, idGroup) VALUES ($u,$id)";
		SQLInsert($SQL);
	}
}

if ($action == "delete") {
	$name = $_POST['name'];
	$SQL = "SELECT id FROM groups WHERE name = '$name'";
	$id = SQLGetChamp($SQL);
	
	$SQL = "DELETE FROM groups WHERE id=$id";
	SQLDelete($SQL);
}

?>

