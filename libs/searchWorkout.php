<?php

include("maLibSQL.pdo.php");
include_once("modele.php");

$name = $_POST['name'];

$SQL = "SELECT * FROM v_workout_exercise WHERE name = \"$name\"";

$result = parcoursRs(SQLSelect($SQL));

if ($result) {
	echo showWorkout($result);
}
else {
	echo showEmptyWorkout();
}

//$_SESSION["idUser"]
?>

