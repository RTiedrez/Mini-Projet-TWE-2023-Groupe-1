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

	$SQL = "SELECT * FROM v_workout_exercise WHERE name = \"$name\" ORDER BY position";

	$result = parcoursRs(SQLSelect($SQL));

	echo showWorkout($result);
}


if ($action == "editor") {
	$name = $_POST['name'];
	
	$SQL2 = "SELECT title FROM exercises";
	
	if ($name == "create-new-workout") {
		$result1 = showNameEdit(false);
		$result2 = "";
	}
	else {
		$result1 = showNameEdit($name);
		$SQL1 = "SELECT * FROM v_workout_exercise WHERE name = \"$name\" ORDER BY position";
		$result2 = showItemWorkout(parcoursRs(SQLSelect($SQL1)));
	}
	
	$result3 = showAddWorkout(parcoursSel(SQLSelect($SQL2), "title"));
	
	$result = array("name-workout" => $result1, "workout-content" => $result2, "workout-add" => $result3);
	echo json_encode($result);
}

if ($action == "edit") {
	$name = $_POST['name'];
	$oName = $_POST['oName'];
	$exercises = $_POST['exercises'];
	
	// Réupération des ids
	$SQL = "SELECT id FROM workouts WHERE name = \"$oName\"";
	$id = SQLGetChamp($SQL);
	$idExercises = array();
	
	$index = 0;
	foreach($exercises as $e) {
		$t = $e["title"];
		$d = $e["duration"];
		$SQL = "SELECT id FROM exercises WHERE title = \"$t\"";
		array_push($idExercises , array(SQLGetChamp($SQL),$d,$index));
		$index++;
	}
	
	// Maj des exercices
	$SQL = "SELECT * FROM v_workout_exercise WHERE idWorkout = $id ORDER BY position";
	$req = parcoursRs(SQLSelect($SQL));
	$oExercises = array();
	foreach($req as $o) {
		array_push($oExercises, array($o["idExercise"], $o["duration"], $o["position"]));
	}
	
	// Maj du nom
	if ($oName != $name) {
		$SQL = "UPDATE workouts SET name = \"$name\" WHERE id = $id";	
		SQLUpdate($SQL);
	}
	
	$olen = count($oExercises);
	$nlen = count($idExercises);
	
	$minlen = min(array($olen,$nlen));
	$maxlen = max(array($olen,$nlen));
	
	for($i = 0; $i < $maxlen; $i++) {
		if ($i < $minlen) {
			if ($idExercises[$i] != $oExercises[$i]) {
				$idE = $idExercises[$i][0];
				$d = $idExercises[$i][1];
				$p = $idExercises[$i][2];
				$SQL = "DELETE FROM workout_exercise WHERE position = $p AND idWorkout = $id";
				SQLDelete($SQL);
				$SQL = "INSERT INTO workout_exercise (idExercise, idWorkout, duration, position)
											VALUES ($idE,$id,\"$d\",$p)";
				SQLInsert($SQL);
			}
		}
		else if ($nlen == $maxlen) {
			$idE = $idExercises[$i][0];
			$d = $idExercises[$i][1];
			$p = $idExercises[$i][2];
			$SQL = "INSERT INTO workout_exercise (idExercise, idWorkout, duration, position)
										VALUES ($idE,$id,\"$d\",$p)";
			SQLInsert($SQL);
		}
		else {
			$p = $oExercises[$i][2];
			$SQL = "DELETE FROM workout_exercise WHERE position = $p AND idWorkout = $id";
			SQLDelete($SQL);
		}
	}
}

if ($action == "add") {
	$name = $_POST['name'];
	$exercises = $_POST['exercises'];
	
	// Réupération des ids
	$idExercises = array();
	
	$index = 0;
	foreach($exercises as $e) {
		$t = $e["title"];
		$d = $e["duration"];
		$SQL = "SELECT id FROM exercises WHERE title = \"$t\"";
		array_push($idExercises , array(SQLGetChamp($SQL),$d,$index));
		$index++;
	}
	
	// Création
	$SQL = "INSERT INTO workouts (idCoach, name) VALUES (1, \"$name\")"; //ajouter id coach	
	$id = SQLInsert($SQL);
	
	// Ajout
	foreach($idExercises as $e) {
		$idE = $e[0];
		$d = $e[1];
		$p = $e[2];
		$SQL = "INSERT INTO workout_exercise (idExercise, idWorkout, duration, position)
											VALUES ($idE,$id,\"$d\",$p)";
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

