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
	$hasmedia = $_POST['hasmedia'];
	
	// Réupération de l'id
	$SQL = "SELECT id FROM exercises WHERE title = \"$oName\"";
	$id = SQLGetChamp($SQL);
	
	if ($hasmedia == "true") {
		$media = $_FILES['media'];
		$uploadDir = "./media/";
		$fileName = $media["name"];
		$path = $uploadDir . $fileName;
		if (!(move_uploaded_file($media["tmp_name"], ".".$path))) {
			$media = false;
		}
		$SQL = "UPDATE exercises SET title = \"$name\", description = \"$desc\", file = \"$path\" WHERE id = $id";
	}
	else {
		$SQL = "SELECT file FROM exercises WHERE id = \"$id\"";
		$path = SQLGetChamp($SQL);
		$media = $_POST['media'];
		if ($path == $media) {
			$SQL = "UPDATE exercises SET title = \"$name\", description = \"$desc\" WHERE id = $id";
		}
		$SQL = "UPDATE exercises SET title = \"$name\", description = \"$desc\", file = NULL WHERE id = $id";
	}

	SQLUpdate($SQL);
}

if ($action == "add") {
	$name = $_POST['name'];
	$desc = $_POST['desc'];
	$hasmedia = $_POST['hasmedia'];
	
	if ($hasmedia == "true") {
		$media = $_FILES['media'];
		$uploadDir = "../media/";
		$fileName = $media["name"];
		$path = $uploadDir . $fileName;
		if (!(move_uploaded_file($media["tmp_name"], $path))) {
			$media = false;
		}
	}
	else {
		$media = false;
	}
	
	// Création
	if ($media) {
		$SQL = "INSERT INTO exercises (title, description, file) VALUES (\"$name\", \"$desc\", \"$path\")"; //ajouter id coach
	}
	else {
		$SQL = "INSERT INTO exercises (title, description) VALUES (\"$name\", \"$desc\")";
	}
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

