<?php

include_once("maLibSQL.pdo.php");
include_once("modele.php");

$action = $_POST['action'];
$name = $_POST['name'];

if ($action == "list") {
	$SQL = "SELECT nomUser FROM v_requests"; // ajouter idCoach

	if ($name != "") {
		$SQL .= " WHERE nomUser LIKE ";
		$SQL .= "'$name%'";
	}

	$result = parcoursRs(SQLSelect($SQL));

	if ($result) {
		echo showEntry($result, "requester", "nomUser");
	}
	else {
		echo json_encode(false);
	}
}

if ($action == "accept") {
	$SQL = "SELECT id FROM users WHERE login = '$name'";
	$id = SQLGetChamp($SQL);
	
	$SQL = "UPDATE users SET idCoach = 1";// ajouter idCoach
	//$SQL .= $_SESSION[];
	$SQL .= " WHERE id = '$id'";
	SQLUpdate($SQL);
	
	$SQL = "DELETE FROM requests WHERE idUser=$id"; // ajouter idCoach
	SQLDelete($SQL);
}

if ($action == "decline") {
	
	$SQL = "SELECT id FROM users WHERE login = '$name'";
	$id = SQLGetChamp($SQL);
	
	$SQL = "DELETE FROM requests WHERE idUser=$id"; // ajouter idCoach
	SQLDelete($SQL);
}

//$_SESSION["idUser"]
?>

