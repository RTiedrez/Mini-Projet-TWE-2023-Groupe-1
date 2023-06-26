<?php

include("maLibSQL.pdo.php");
include_once("modele.php");

$name = $_POST['name'];

$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";

$result = parcoursRs(SQLSelect($SQL));

if ($result) {
	echo showExercise($result);
}
else {
	echo showEmptyExercise();
}

//$_SESSION["idUser"]
?>

