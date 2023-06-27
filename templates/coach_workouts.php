<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_workouts");
	die("");
}

?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>

var url = 'libs/search_workouts.php';

function showWorkout(name) {
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"workout",name:name},
		success: function(result) {
			if (result != $('#right').html()) {
				$('#right').html(result);
			}
		}
	});
}

function selected(id) {
	showWorkout($(".item").eq(id).text());
	$(".item").eq(id).removeClass().addClass("item-selected");
}

function showWorkoutList(id) {
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
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"editor",name:name},
		success: function(result) {
			console.log(result);
			r = JSON.parse(result);
			$('#nameEditor').html(r.nameWorkout);
			$('#left-list').html(r.freeUsers);
			$('#right-list').html(r.workoutUsers);
		}
	});
	
	$("#editor").show()
	$("#left, #right").hide();
}

function addWorkout() {
	var users = [];
	var name = $("#editName").val();
	
	$("#right-list p").each(function() {
		users.push($(this).text());
	});
	
	if ($("#editor").data("mode") == "add") {
		data = {action:"add",name:name,users:users};
	}
	if ($("#editor").data("mode") == "edit") {
		data = {action:"edit",name:name,users:users,oName:$("#editor").data("name")};
	}
	
	$.ajax({
		url: url,
		method: 'POST',
		data: data,
		success: function(result) {
		}
	});
	
	init();
}

function delWorkout() {
	var name = $("#editor").data("name");
	
	if (name != "") {
		$.ajax({
			url: url,
			method: 'POST',
			data: {action:"delete",name:name},
			success: function(result) {
			}
		});
	}	
	init();
}

function init() {
	showWorkoutList();
	
	$("#editor").hide()
	$("#left, #right").show();
	
	$("#right-list").sortable({revert:true}).disableSelection();
	/*
	$(".draggable").each(function() {
		$(this).draggable({connectToSortable: "#right-list",helper:"clone"}).disableSelection();
	});
	*/
	$("#left-list").on('mouseenter', "p", function() {
		$(this).draggable({connectToSortable:"#right-list",helper:"clone",revert:"invalid"}).disableSelection();
	});
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	console.log("Loaded");
	init();
	
	$("#left").on("click", ".item", function() {
		$(".item-selected").removeClass().addClass("item");
		$(this).removeClass().addClass("item-selected");
		var name = $(this).text();
		showWorkout(name);
	});
	
	
	// Gérer le passage en mode ajout
	$("#content").on("click", "#left .item-add", function() {
		$("h1").html("Add a workout");
		$("#editor").data("mode","add");
		$("#editor").data("name","");
		$("#del").hide();
		loadEditor("create-new-workout");
	});
	
	// Gérer le passage en mode édition
	$("#content").on("click", "#right .item-add", function() {
		var name = $(".item-selected").text();
		$("h1").html("Edit a workout");
		$("#editor").data("mode","edit");
		$("#editor").data("name",name);
		$("#del").show();
		loadEditor($(".item-selected").text());
	});
	
	
	// Gérer le passage en mode affichage
	$("#content").on("click", "#can", function() {
		$("h1").html("Workout");
		init();
	});
	
	$("#content").on("click", "#val", function() {
		$("h1").html("Workout");
		addWorkout();
	});
	
	$("#content").on("click", "#del", function() {
		$("h1").html("Workout");
		delWorkout();
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

.ui-state-default {
	cursor:move;
	background-color:rgb(20,20,20);
	border:solid 1px red;
}

#workoutEditor, #dragUserList {
	size:relative;
	float:left;
	width:45%;
	background-color:rgb(200,200,200);
	min-height:30vh;
	border-radius:10px;
	padding:10px;
	margin:10px;
}

ul {
	min-height:20vh;!important
}

</style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Workouts</h1>
	
	<div id="editor">
		<div id="nameEditor"></div>
		<div id="dragUserList">
			<ul id="left-list" class="sortable-list">
			</ul>
		</div>
		<div id="workoutEditor">
			<ul id="right-list" class="sortable-list">
			</ul>
			<input id=val type=button value=Validate>
			<input id=del type=button value=Delete>
			<input id=can type=button value=Cancel>
		</div>
	</div>
	
	<div id="left" class="column"></div>
	<div id="right" class="column"></div>
	
</div>