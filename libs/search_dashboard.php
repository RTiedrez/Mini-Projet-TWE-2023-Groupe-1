<?php

include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("modele.php");

$name = $_POST['name'];


$SQL = "SELECT login FROM users";

if ($name == "") {
	$SQL = "SELECT login FROM users";
}
else {
	$SQL = "SELECT login FROM users WHERE login LIKE ";
	$SQL .= "'$name%'";
}

$result = parcoursRs(SQLSelect($SQL));

echo showEntry($result, "user", "login");

?>

