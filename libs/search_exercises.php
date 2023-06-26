<?php

include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("modele.php");

$action = $_POST['action'];

if ($action == "list") {
	$SQL = "SELECT * FROM exercises"; // ajouter idCoach
		
	$result = parcoursRs(SQLSelect($SQL));

	showEntry($result, "exercise", "title");
}

if ($action == "exercise") {
	$name = $_POST['name'];
	
	$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";

	$result = parcoursRs(SQLSelect($SQL));

	showExercise($result);
}

?>

