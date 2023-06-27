<?php

include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("modele.php");

$action = $_POST['action'];

if ($action == "list") {
	$SQL = "SELECT * FROM exercises"; // ajouter idCoach
		
	$result = parcoursRs(SQLSelect($SQL));

	echo showEntry($result, "exercise", "title");
}

if ($action == "exercise") {
	$name = $_POST['name'];
	
	$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";

	$result = parcoursRs(SQLSelect($SQL));

	echo showExercise($result);
}


if ($action == "editor") {
	$name = $_POST['name'];
	
	$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";
	
	if ($name == "create-new-exercise") {
		$result = false;
		echo json_encode(showExerciseEditor(false));
	}
	else {
		$result = parcoursRs(SQLSelect($SQL));
		echo json_encode(showExerciseEditor($result[0]));
	}
}

if ($action == "edit") {
	$name = $_POST['name'];
	$oName = $_POST['oName'];
	$desc = $_POST['desc'];
	
	// Réupération de l'id
	$SQL = "SELECT id FROM exercises WHERE title = \"$oName\"";
	$id = SQLGetChamp($SQL);
	
	$SQL = "UPDATE exercises SET title = \"$name\", description = \"$desc\" WHERE id = $id";	
	SQLUpdate($SQL);
}

if ($action == "add") {
	$name = $_POST['name'];
	$desc = $_POST['desc'];
	
	// Création
	$SQL = "INSERT INTO exercises (title, description) VALUES (\"$name\", \"$desc\")"; //ajouter id coach
		
	SQLInsert($SQL);
}

if ($action == "delete") {
	$name = $_POST['name'];
	$SQL = "SELECT id FROM exercises WHERE title = '$name'";
	$id = SQLGetChamp($SQL);
	
	$SQL = "DELETE FROM exercises WHERE id=$id";
	SQLDelete($SQL);
}


?>

