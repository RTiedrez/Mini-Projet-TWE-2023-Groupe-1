<?php

	//------------------------ General  ------------------------//
	
	// Affichage d'une liste d'item qui seront sortable
	function showSortList($tab) {
		$s = "";
		if ($tab) {
			foreach($tab as $t) {
				$s .= "<div class=sort-item><p>$t</p></div>";
			}
		}
		return $s;
	}
	
	// Affichage d'un éditeur de nom
	function showNameEdit($name) {
		$s = "Edit the name : ";
		if ($name) {
			$s .= "<input type=text id=edit-name value=\"$name\">";
		}
		else {
			$s .= "<input type=text id=edit-name>";
		}
		return $s;
	}

	// Affichage d'une liste d'item
	function showEntry($tab, $type) {
		$s = "<div id=entry>";
		if ($tab) {
			foreach($tab as $t) {
				$s .= "<div class=item>";
				$s .= "<p>$t</p>";
				if ($type == "request") {
					$s .= '<div class=images>';
					$s .= '<img class="accept" src="ressources/done.png"/>';
					$s .= '<img class="decline" src="ressources/close.png"/>';
					$s .= '</div>';
				}
				$s .= "</div>";
			}
		}
		else {
			$s .= "<div class=item><p class=empty>The list is empty!</p></div>";
		}
		if (($type == "group") || ($type == "exercise") || ($type == "workout")) {
			$s .= "<div class=item-add>";
			$s .= "<p>Add $type</p>";
			$s .= "</div>";
		}
		$s .= "</div>";
		return $s;
	}

	//------------------------ Exercises  ------------------------//
	
	// Affichage d'un exercice
	function showExercise($tab) {
		$s = "<div id=exercise>";
		if ($tab) {
			foreach($tab as $exercise) {
				$t = $exercise["title"];
				$d = $exercise["description"];
				$f = $exercise["file"];
				$s .= "<p>Exercice : $t</p><hr/>";
				$s .= "<p>Description : $d</p><hr/>";
				if ($f != null) {
					$s .= "<img src=$f><hr/>";
				}
			}
		}
		else {
			$s .= "<p>Empty exercise</p><hr/>";
		}
		$s .= "<div class=item-add>";
		$s .= "<p class=exercise>Edit exercise</p>";
		$s .= "</div>";
		$s .= "</div>";
		return $s;
	}
	
	// Affichage de l'éditeur d'exercices
	function showExerciseEditor($tab) {
		$result = array();
		
		$title = "";
		$desc = "";
		$file = "";
		
		if ($tab) {
			$title = $tab["title"];
			$desc = $tab["description"];
			$file = $tab["file"];
		}
		$s = "<input type=text id=edit-name value=\"$title\"><br/>";
		$s .= "<textarea id=edit-desc>$desc</textarea>";
		
		$result["property-editor"] = $s;
		if ($file != "") {
			$result["current-media"] = ltrim($file, "./media/");
		}
		else {
			$result["current-media"] = false;
		}
		
		
		return $result;
	}

	//------------------------ Workout  ------------------------//

	// Affichage d'un workout
	function showWorkout($tab) {
		$s = "<div id=workout>";
		if ($tab) {
			foreach($tab as $workout) {
				$t = $workout["title"];
				$d = $workout["duration"];
				$s .= "<p>Exercise : $t<br/>Durée : $d</p><hr/>";
			}
		}
		else {
			$s .= "<p>Empty workout</p><hr/>";
		}
		$s .= "<div class=item-add>";
		$s .= "<p class=workout>Edit workout</p>";
		$s .= "</div>";
		$s .= "</div>";
		return $s;
	}

	// Affichage de la barre permettant l'ajout d'un exercice dans un workout
	function showAddWorkout($tab) {
		$s = "<hr/><select name=\"Exercise\" id=\"add-exercise\">";
		if ($tab) {
			foreach($tab as $t) {
				$s .= "<option value=\"$t\">$t</option>";
			}
		}
		$s .= "</select>";
		$s .= "<input id=\"add-duration\" type=text required pattern=\"[0-9]{2}:[0-9]{2}:[0-9]{2}\" value=\"00:00:00\">";
		$s .= "<input id=add type=button value=+><hr/>";
		return $s;
	}
	
	// Affichage d'un exercice dans la liste d'exercice des workouts
	function showItemWorkout($tab) {
		$s = "";
		if ($tab) {
			foreach($tab as $t) {
				$title = $t["title"];
				$dura = $t["duration"];
				$s .= "<div class=big-item><p>$title</p><input type=text required pattern=\"[0-9]{2}:[0-9]{2}:[0-9]{2}\" value=\"$dura\"><input type=button value=X></div>";
			}
		}
		return $s;
	}

	//------------------------ Group ------------------------//
	
	// Affichage d'un groupe
	function showGroup($tab) {
		$s = "<div id=group>";
		if ($tab) {
			foreach($tab as $group) {
				$l = $group["login"];
				$s .= "<p>Membre : $l</p><hr/>";
			}
		}
		else {
			$s .= "<p>Empty group</p><hr/>";
		}
		$s .= "<div class=item-add>";
		$s .= "<p class=group>Edit group</p>";
		$s .= "</div>";
		$s .= "</div>";
		return $s;
	}

?>

















