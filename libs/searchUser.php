<?php

include("maLibSQL.pdo.php");
include_once("modele.php");

$name = $_POST['name'];


$SQL = "SELECT login FROM users"; // ajouter idCoach

if ($name == "") {
	$SQL = "SELECT login FROM users";
}
else {
	$SQL = "SELECT login FROM users WHERE login LIKE ";
	$SQL .= "'$name%'";
}

$result = parcoursRs(SQLSelect($SQL));

if ($result) {
	echo showEntry($result, "user", "login");
}
else {
	echo json_encode(false);
}



//$_SESSION["idUser"]
?>

