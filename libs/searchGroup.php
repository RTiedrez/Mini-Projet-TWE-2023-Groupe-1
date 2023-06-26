<?php

include("maLibSQL.pdo.php");
include_once("modele.php");

$name = $_POST['name'];

$SQL = "SELECT * FROM v_user_group WHERE nomGroupe = \"$name\"";

$result = parcoursRs(SQLSelect($SQL));

if ($result) {
	echo showGroup($result);
}
else {
	echo showEmptyGroup();
}

//$_SESSION["idUser"]
?>

