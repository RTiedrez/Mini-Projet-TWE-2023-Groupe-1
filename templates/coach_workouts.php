<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_workouts");
	die("");
}

include_once("libs/maLibSQL.pdo.php");
include_once("libs/modele.php");

?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>

<script>

function showWorkout(name) {
	$.ajax({
		url: 'libs/searchWorkout.php',
		method: 'POST',
		data: {name:name},
		success: function(result) {
			if (result != $('#right').html()) {
				$('#right').html(result);
			}
		}
	});
}

function init() {
	showWorkout($(".item").first().text());
	$(".item").first().removeClass().addClass("item-selected");
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	console.log("Loaded");
	init();
	
	$("#left").on("click", ".item", function() {
		console.log($(this).text());
		$(".item-selected").removeClass().addClass("item");
		$(this).removeClass().addClass("item-selected");
		var name = $(this).text();
		showWorkout(name);
	});
	
});

</script>

<!------------------------------------------------------------->

<style>

body {
	background-image: url('ressources/background.jpg');
	background-position: top center;
	padding:10px;
}

div {
	color:white;
}

#content {
	background-color:rgba(10,10,10,.5);
	padding:10px;
	margin-top:10px;
	border-radius:20px;
	min-height: 50vh;
	height:100%;
}

.column {
	float:left;
	width:50%;
}

.item-selected p {
	border: solid 3px red;
}

.workout {
	background-color:rgb(200,200,200);
	color:black;
	padding:10px;
	margin:10px;
	border-radius:10px;
	cursor:pointer;
}

.item-add p {
	background-color:red;
	color:white;
}

#workout {
	background-color:rgb(200,200,200);
	color:black;
	padding:10px;
	margin:10px;
	border-radius:10px;
}

</style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Workouts</h1>
	
	<div id="left" class="column">
	<?php
		$SQL = "SELECT name FROM workouts"; // ajouter idCoach
		
		$result = parcoursRs(SQLSelect($SQL));

		if ($result) {
			echo showEntry($result, "workout", "name");
		}
		else {
			echo json_encode(false);
		}
	?>
	</div>
	
	<div id="right" class="column"></div>

</div>
