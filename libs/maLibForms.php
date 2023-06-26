<?php

//------------------------ General

function showDragList($tab) {
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
		$s .= "<input id=editName value=$name>";
	}
	else {
		$s .= "<input id=editName>";
	}
	return $s;
}

function showEntry($tab, $class, $key) {
	echo "<div id=entry>";
	if ($tab) {
		foreach($tab as $value) {
			echo "<div class=item>";
			echo "<p class=$class>$value[$key]</p>";
			if ($class == "requester") {
				echo '<div class=images>';
				echo '<img class="accept" src="ressources/done.png"/>';
				echo '<img class="decline" src="ressources/close.png"/>';
				echo '</div>';
			}
			echo "</div>";
		}
	}
	else {
		echo "<p class=empty>The list is empty!</p>";
	}
	if (($class == "group") || ($class == "exercise") || ($class == "workout")) {
		echo "<div class=item-add>";
		echo "<p class=$class>Add $class</p>";
		echo "</div>";
	}
	echo "</div>";
}



//------------------------ Exercises

function showExercise($tab) {
	echo "<div id=exercise>";
	if ($tab) {
		foreach($tab as $exercise) {
			$t = $exercise["title"];
			$d = $exercise["description"];
			echo "<p>Exercice : $t</p><hr/>";
			echo "<p>Description : $d</p><hr/>";
		}
	}
	else {
		echo "<p>Empty exercise</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=exercise>Edit exercise</p>";
	echo "</div>";
	echo "</div>";
}

//------------------------ Workout

function showWorkout($tab) {
	echo "<div id=workout>";
	if ($tab) {
		foreach($tab as $workout) {
			$t = $workout["title"];
			$d = $workout["duration"];
			echo "<p>Exercise : $t Durée : $d</p><hr/>";
		}
	}
	else {
		echo "<p>Empty workout</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=workout>Edit workout</p>";
	echo "</div>";
	echo "</div>";
}

//------------------------ Group

function showGroup($tab) {
	echo "<div id=group>";
	if ($tab) {
		foreach($tab as $group) {
			$l = $group["login"];
			echo "<p>Membre : $l</p><hr/>";
		}
	}
	else {
		echo "<p>Empty group</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=group>Edit group</p>";
	echo "</div>";
	echo "</div>";
}

?>

















