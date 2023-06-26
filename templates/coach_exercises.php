<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_exercises");
	die("");
}

?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>

var url = 'libs/search_exercises.php';

function showExercise(name) {
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"exercise",name:name},
		success: function(result) {
			if (result != $('#right').html()) {
				$('#right').html(result);
			}
		}
	});
}

function selected(id) {
	showExercise($(".item").eq(id).text());
	$(".item").eq(id).removeClass().addClass("item-selected");
}

function showExerciseList(id) {
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"list"},
		success: function(result) {
			if (result != $('#left').html()) {
				$('#left').html(result);
			}
			if (id != null) {
				selected(id);
			}
			else {
				selected(0);
			}
		}
	});
}

function loadEditor(name) {
	$("#left, #right, #editor").toggle();
	/*
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"ExerciseEditor",name:name},
		success: function(result) {
			if (result != $('#right').html()) {
				$('#right').html(result);
				initDrag();
			}
		}
	});
	*/
}

function init() {
	$("#editor").toggle()
	showExerciseList();
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	console.log("Loaded");
	init();
	
	$("#left").on("click", ".item", function() {
		$(".item-selected").removeClass().addClass("item");
		$(this).removeClass().addClass("item-selected");
		var name = $(this).text();
		showExercise(name);
	});
	
	
	// Gérer le passage en mode édition
	$("#content").on("click", "#left .item-add", function() {
		$("h1").html("Exercise editor");
		loadEditor("create-new-exercise");
	});
	
	$("#content").on("click", "#right .item-add", function() {
		$("h1").html("Exercise editor");
		loadEditor($(".item-selected").text());
	});
	
	
	// Gérer le passage en mode affichage
	$("#content").on("click", "#can", function() {
		$("h1").html("Exercises");
		init();
	});
	
	$("#content").on("click", "#val", function() {
		$("h1").html("Exercises");
		init();
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

.exercise {
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

#exercise {
	background-color:rgb(200,200,200);
	color:black;
	padding:10px;
	margin:10px;
	border-radius:10px;
}

</style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Exercises</h1>
	<div id="editor" class="column">cc</div>
	<div id="left" class="column"></div>
	<div id="right" class="column"></div>
	
</div>
