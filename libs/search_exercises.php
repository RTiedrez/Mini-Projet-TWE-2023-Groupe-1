<?php
	// Mini projet TWE 2023 - Groupe 1
	// Fichier réalisé par Jules Dumezy

	// Inclusion des librairies
	include_once("maLibSQL.pdo.php");
	include_once("maLibForms.php");
	include_once("modele.php");

	// Récupération de l'action
	$action = $_POST['action'];

	// Si une liste est demandée
	if ($action == "list") {
		
		// Création de la requête
		$SQL = "SELECT * FROM exercises";
		
		// Exécution de le requête
		$result = parcoursSel(SQLSelect($SQL), "title");
		
		// Affichage du résultat
		echo showEntry($result, "exercise");
	}

	// Si un exercice est demandé
	if ($action == "exercise") {
		
		// Récupération des variables
		$name = $_POST['name'];
		
		// Création de la requête
		$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";

		// Exécution de le requête
		$result = parcoursRs(SQLSelect($SQL));

		// Affichage du résultat
		echo showExercise($result);
	}

	// Si l'éditeur est demandé
	if ($action == "editor") {

		// Récupération des variables
		$name = $_POST['name'];
		
		// Si l'éditeur est chargé en mode nouvel exercice
		if ($name == "create-new-exercise") {
			$result = false;
			
			// Affichage du résultat
			echo json_encode(showExerciseEditor(false));
		}
		// Si l'éditeur est chargé mode éditon d'un exercice
		else {
			$SQL = "SELECT * FROM exercises WHERE title = \"$name\"";
			$result = parcoursRs(SQLSelect($SQL));
			
			// Affichage du résultat
			echo json_encode(showExerciseEditor($result[0]));
		}
	}

	// Si un exercice doit être modifié
	if ($action == "edit") {

		// Récupération des variables
		$name = $_POST['name'];
		$oName = $_POST['oName'];
		$desc = $_POST['desc'];
		$hasmedia = $_POST['hasmedia'];
		
		// Récupération de l'id del'exercice
		$SQL = "SELECT id FROM exercises WHERE title = \"$oName\"";
		$id = SQLGetChamp($SQL);
		
		// Si un fichier a été passé en argument
		if ($hasmedia == "true") {
			// Récupération et enregistrement du fichier
			$media = $_FILES['media'];
			$uploadDir = "./media/";
			$fileName = $media["name"];
			$path = $uploadDir . $fileName;
			if (!(move_uploaded_file($media["tmp_name"], ".".$path))) {
				$media = false;
			}
			
			$SQL = "UPDATE exercises SET title = \"$name\",
										description = \"$desc\",
										fichier = \"$path\"
										WHERE id = $id";
		}
		// Si aucun fichier n'a été passé en argument
		else {
			$SQL = "SELECT fichier FROM exercises WHERE id = \"$id\"";
			$path = SQLGetChamp($SQL);
			$media = $_POST['media'];
			if ($path == $media) {
				$SQL = "UPDATE exercises SET title = \"$name\",
											description = \"$desc\"
											WHERE id = $id";
			}
			$SQL = "UPDATE exercises SET title = \"$name\",
										description = \"$desc\",
										fichier = NULL
										WHERE id = $id";
		}

		SQLUpdate($SQL);
	}

	// Si un exercice doit être ajouté
	if ($action == "add") {
		
		// Récupération des variables
		$name = $_POST['name'];
		$desc = $_POST['desc'];
		$hasmedia = $_POST['hasmedia'];
		
		// Si un fichier a été passé en argument
		if ($hasmedia == "true") {
			// Récupération et enregistrement du fichier
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
		
		// Création de l'exercice
		if ($media) {
			$SQL = "INSERT INTO exercises (title, description, fichier)
									VALUES (\"$name\", \"$desc\", \"$path\")";
		}
		else {
			$SQL = "INSERT INTO exercises (title, description)
									VALUES (\"$name\", \"$desc\")";
		}
		SQLInsert($SQL);
	}

	// Si un exercice doit être supprimé
	if ($action == "delete") {
		
		// Récupération des variables
		$name = $_POST['name'];
		
		// Récupération de l'id de l'exercice
		$SQL = "SELECT id FROM exercises WHERE title = '$name'";
		$id = SQLGetChamp($SQL);
		
		// Suppression de l'exercice
		$SQL = "DELETE FROM exercises WHERE id=$id";
		SQLDelete($SQL);
	}

?>

