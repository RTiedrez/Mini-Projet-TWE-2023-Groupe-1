<?php

include_once("maLibSQL.pdo.php");

function showEntry($tabUsers, $class, $key) {
	echo "<div id=entry>";
	foreach($tabUsers as $value) {
		echo "<div class=item>";
		echo "<p class=$class>";
		echo $value[$key];
		echo "</p>";
		if ($class == "requester") {
			echo '<div class=images>';
			echo '<img class="accept" src="ressources/done.png"/>';
			echo '<img class="decline" src="ressources/close.png"/>';
			echo '</div>';
		}
		echo "</div>";
	}
	if (($class == "group") || ($class == "exercise") || ($class == "workout")) {
		echo "<div class=item-add>";
		echo "<p class=$class>Add $class</p>";
		echo "</div>";
	}
	echo "</div>";
}

function showExercise($tab) {
	echo "<div id=exercise>";
	foreach($tab as $exercise) {
		$t = $exercise["title"];
		$d = $exercise["description"];
		echo "<p>Exercice : $t</p><hr/>";
		echo "<p>Description : $d</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=exercise>Edit exercise</p>";
	echo "</div>";
	echo "</div>";
}

function showWorkout($tab) {
	echo "<div id=workout>";
	foreach($tab as $exercise) {
		$t = $exercise["title"];
		$d = $exercise["duration"];
		echo "<p>Exercise : $t Durée : $d</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=workout>Edit workout</p>";
	echo "</div>";
	echo "</div>";
}

function showGroup($tab) {
	echo "<div id=group>";
	foreach($tab as $exercise) {
		$l = $exercise["login"];
		echo "<p>Membre : $l</p><hr/>";
	}
	echo "<div class=item-add>";
	echo "<p class=group>Edit group</p>";
	echo "</div>";
	echo "</div>";
}

function showEmptyExercise() {
	echo "<div id=exercise>";
	echo "<p>Empty exercise</p><hr/>";
	echo "<div class=item-add>";
	echo "<p class=exercise>Edit exercise</p>";
	echo "</div>";
	echo "</div>";
}

function showEmptyWorkout() {
	echo "<div id=workout>";
	echo "<p>Empty workout</p><hr/>";
	echo "<div class=item-add>";
	echo "<p class=workout>Edit workout</p>";
	echo "</div>";
	echo "</div>";
}

function showEmptyGroup() {
	echo "<div id=group>";
	echo "<p>Empty group</p><hr/>";
	echo "<div class=item-add>";
	echo "<p class=group>Edit group</p>";
	echo "</div>";
	echo "</div>";
}

?>
