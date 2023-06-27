<?php

include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("modele.php");

$action = $_POST['action'];

if ($action == "list") {
	$SQL = "SELECT name FROM workouts"; // ajouter idCoach
		
	$result = parcoursRs(SQLSelect($SQL));

	echo showEntry($result, "workout", "name");
}

if ($action == "workout") {
	$name = $_POST['name'];

	$SQL = "SELECT * FROM v_workout_exercise WHERE name = \"$name\"";

	$result = parcoursRs(SQLSelect($SQL));

	echo showWorkout($result);
}


if ($action == "editor") {
	$name = $_POST['name'];
	
	$SQL1 = "SELECT title FROM exercises";
	
	if ($name == "create-new-workout") {
		$result1 = showNameEdit(false);
		$result3 = showSortList(false);
	}
	else {
		$result1 = showNameEdit($name);
		$SQL2 = "SELECT title FROM v_workout_exercise WHERE name = \"$name\"";
		$result3 = showSortList(parcoursSel(SQLSelect($SQL2), "title"));
	}
	
	$result2 = showSortList(parcoursSel(SQLSelect($SQL1), "title"));
	
	$result = array("nameWorkout" => $result1, "freeUsers" => $result2, "workoutUsers" => $result3);
	echo json_encode($result);
}

if ($action == "edit") {
	$name = $_POST['name'];
	$oName = $_POST['oName'];
	$users = $_POST['users'];
	
	// Réupération des ids
	$SQL = "SELECT id FROM workouts WHERE name = \"$oName\"";
	$id = SQLGetChamp($SQL);
	$idUsers = array();
	
	foreach($users as $u) {
		$SQL = "SELECT id FROM users WHERE login = \"$u\"";
		array_push($idUsers, SQLGetChamp($SQL));
	}
	
	// Maj du nom
	if ($oName != $name) {
		$SQL = "UPDATE workouts SET name = \"$name\" WHERE id = $id";	
		SQLUpdate($SQL);
	}
	
	// Maj des membres
	$SQL = "SELECT idUser FROM v_user_workout WHERE idWorkout = $id";
	$req = parcoursRS(SQLSelect($SQL));
	$oUsers = array();
	foreach($req as $o) {
		array_push($oUsers, $o["idUser"]);
	}
	
	// Ajout
	$SQL = "INSERT INTO user_workout (idUser, idWorkout) VALUES ";
	foreach($idUsers as $u) {
		if (!(in_array($u, $oUsers))) {
			$SQL = "INSERT INTO user_workout (idUser, idWorkout) VALUES ($u,$id)";
			SQLInsert($SQL);
		}
	}
	
	// Retrait
	foreach($oUsers as $o) {
		if (!(in_array($o, $idUsers))) {
			$SQL = "DELETE FROM user_workout WHERE idUser = $o AND idWorkout = $id";
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
	$SQL = "INSERT INTO workouts (idCoach, name) VALUES (1, \"$name\")"; //ajouter id coach	
	$id = SQLInsert($SQL);
	
	// Ajout
	$SQL = "INSERT INTO user_workout (idUser, idWorkout) VALUES ";
	foreach($idUsers as $u) {
		$SQL = "INSERT INTO user_workout (idUser, idWorkout) VALUES ($u,$id)";
		SQLInsert($SQL);
	}
}

if ($action == "delete") {
	$name = $_POST['name'];
	$SQL = "SELECT id FROM workouts WHERE name = '$name'";
	$id = SQLGetChamp($SQL);
	
	$SQL = "DELETE FROM workouts WHERE id=$id";
	SQLDelete($SQL);
}

?>

