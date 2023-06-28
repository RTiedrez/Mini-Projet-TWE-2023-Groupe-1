<?php

//------------------------ General

function showSortList($tab) {
	$s = "";
	if ($tab) {
		foreach($tab as $t) {
			$s .= "<p class=\"ui-state-default\">$t</p>";
		}
	}
	return $s;
}

function showNameEdit($name) {
	$s = "Edit the name : ";
	if ($name) {
		$s .= "<input type=text id=editName value=\"$name\">";
	}
	else {
		$s .= "<input type=text id=editName>";
	}
	return $s;
}

function showEntry($tab, $class, $key) {
	$s = "<div id=entry>";
	if ($tab) {
		foreach($tab as $value) {
			$s .= "<div class=item>";
			$s .= "<p class=$class>$value[$key]</p>";
			if ($class == "requester") {
				$s .= '<div class=images>';
				$s .= '<img class="accept" src="ressources/done.png"/>';
				$s .= '<img class="decline" src="ressources/close.png"/>';
				$s .= '</div>';
			}
			$s .= "</div>";
		}
	}
	else {
		$s .= "<p class=empty>The list is empty!</p>";
	}
	if (($class == "group") || ($class == "exercise") || ($class == "workout")) {
		$s .= "<div class=item-add>";
		$s .= "<p class=$class>Add $class</p>";
		$s .= "</div>";
	}
	$s .= "</div>";
	return $s;
}

//------------------------ Exercises

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
	$s = "<input type=text id=editName value=\"$title\"><br/>";
	$s .= "<textarea id=editDesc>$desc</textarea>";
	
	$result["property-editor"] = $s;
	if ($file != "") {
		$result["current-media"] = ltrim($file, "./media/");
	}
	else {
		$result["current-media"] = false;
	}
	
	
	return $result;
}

//------------------------ Workout

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

//------------------------ Group

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

















