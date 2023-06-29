<?php
	// Mini projet TWE 2023 - Groupe 1
	// Fichier réalisé par Jules Dumezy

	// Récupération de la session
	session_start();

	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");
	include_once("modele.php");

	// Récupération de l'action
	$action = $_POST['action'];
	
	// Récupération de l'id du coach
	$idCoach = $_SESSION["idUser"];

	// Si une liste est demandée
	if ($action == "list") {
		
		// Création de la requête
		$SQL = "SELECT name FROM workouts WHERE idCoach = $idCoach";
		
		// Exécution de le requête
		$result = parcoursSel(SQLSelect($SQL), "name");
		
		// Affichage du résultat
		echo showEntry($result, "workout");
	}

	// Si un workout est demandé
	if ($action == "workout") {
		
		// Récupération des variables
		$name = $_POST['name'];
		
		// Création de la requête
		$SQL = "SELECT * FROM v_workout_exercise WHERE name = \"$name\" ORDER BY position";

		// Exécution de le requête
		$result = parcoursRs(SQLSelect($SQL));
		
		// Affichage du résultat
		echo showWorkout($result);
	}

	// Si l'éditeur est demandé
	if ($action == "editor") {

		// Récupération des variables
		$name = $_POST['name'];
		
		// Si l'éditeur est chargé en mode nouveau workout
		if ($name == "create-new-workout") {
			// Le nom du workout est vide
			$nameEdit = showNameEdit(false);
			
			// Le contenu du workout est vide
			$workoutContent = "";
		}
		// Si l'éditeur est chargé mode éditon d'un workout
		else {
			// Le nom du workout est celui passé en argument
			$nameEdit = showNameEdit($name);
			
			// Les exercices du groupe sont listés dans l'ordre
			$SQL = "SELECT * FROM v_workout_exercise WHERE name = \"$name\" ORDER BY position";
			$workoutContent = showItemWorkout(parcoursRs(SQLSelect($SQL)));
		}
		
		// Ajout du bloc "ajout d'exercice"
		$SQL = "SELECT title FROM exercises";
		$workoutAdd = showAddWorkout(parcoursSel(SQLSelect($SQL), "title"));
		
		// On enregistre les résultats dans un tableau associatif
		$result = array("name-workout" => $nameEdit,
						"workout-content" => $workoutContent,
						"workout-add" => $workoutAdd);
		
		// Affichage du résultat
		echo json_encode($result);
	}	
		
	// Si un workout doit être modifié
	if ($action == "edit") {

		// Récupération des variables
		$name = $_POST['name'];
		$oName = $_POST['oName'];
		$exercises = $_POST['exercises'];
		
		// Récupération des id des nouveaux exercices
		$SQL = "SELECT id FROM workouts WHERE name = \"$oName\" AND idCoach = $idCoach";
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
		
		// Récupération des id des exercices du workout
		$SQL = "SELECT * FROM v_workout_exercise WHERE idWorkout = $id ORDER BY position";
		$req = parcoursRs(SQLSelect($SQL));
		$oExercises = array();
		
		foreach($req as $o) {
			array_push($oExercises, array($o["idExercise"], $o["duration"], $o["position"]));
		}
		
		// Mise à jour du nom du workout
		if ($oName != $name) {
			$SQL = "UPDATE workouts SET name = \"$name\" WHERE id = $id";	
			SQLUpdate($SQL);
		}
		
		// Calcul du nombre d'exercices (anciens et nouveaux)
		$olen = count($oExercises);
		$nlen = count($idExercises);
		$minlen = min(array($olen,$nlen));
		$maxlen = max(array($olen,$nlen));
		
		// Mise à jour du workout
		for($i = 0; $i < $maxlen; $i++) {
		
			// Mise à jour d'exercice existant
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
			
			// Ajout des exercices en plus
			else if ($nlen == $maxlen) {
				$idE = $idExercises[$i][0];
				$d = $idExercises[$i][1];
				$p = $idExercises[$i][2];
				$SQL = "INSERT INTO workout_exercise (idExercise, idWorkout, duration, position)
											VALUES ($idE,$id,\"$d\",$p)";
				SQLInsert($SQL);
			}
			
			// Retrait des exercices en trop
			else {
				$p = $oExercises[$i][2];
				$SQL = "DELETE FROM workout_exercise WHERE position = $p AND idWorkout = $id";
				SQLDelete($SQL);
			}
		}
	}

	// Si un workout doit être ajouté
	if ($action == "add") {

		// Récupération des variables
		$name = $_POST['name'];
		$exercises = $_POST['exercises'];
		
		// Récupération des id des exercices
		$idExercises = array();
		
		$index = 0;
		foreach($exercises as $e) {
			$t = $e["title"];
			$d = $e["duration"];
			$SQL = "SELECT id FROM exercises WHERE title = \"$t\"";
			array_push($idExercises , array(SQLGetChamp($SQL),$d,$index));
			$index++;
		}
		
		// Création du workout
		$SQL = "INSERT INTO workouts (idCoach, name) VALUES ($idCoach, \"$name\")";
		$id = SQLInsert($SQL);
		
		// Ajout des exercices
		foreach($idExercises as $e) {
			$idE = $e[0];
			$d = $e[1];
			$p = $e[2];
			$SQL = "INSERT INTO workout_exercise (idExercise, idWorkout, duration, position)
												VALUES ($idE,$id,\"$d\",$p)";
			SQLInsert($SQL);
		}
	}

	// Si un workout doit être supprimé
	if ($action == "delete") {
		
		// Récupération des variables
		$name = $_POST['name'];
		
		// Récupération de l'id du workout
		$SQL = "SELECT id FROM workouts WHERE name = \"$name\" AND idCoach = $idCoach";
		$id = SQLGetChamp($SQL);
		
		// Suppression du workout
		$SQL = "DELETE FROM workouts WHERE id=$id";
		SQLDelete($SQL);
	}

?>

