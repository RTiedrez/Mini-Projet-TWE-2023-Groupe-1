// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

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
			r = JSON.parse(result);
			$('#name-workout').html(r["name-workout"]);
			$('#workout-content').html(r["workout-content"]);
			$('#workout-add').html(r["workout-add"]);
		}
	});
	
	$("#editor").show()
	$("#left, #right").hide();
}

function addWorkout() {
	
	var exercises = [];
	var name = $("#edit-name").val();
	
	$(".big-item").each(function() {
		var t = $(this).find("p").text();
		var d = $(this).find("input[type=text]").val();
		exercises.push({title:t,duration:d});
	});
	
	if ($("#editor").data("mode") == "add") {
		data = {action:"add",name:name,exercises:exercises};
	}
	if ($("#editor").data("mode") == "edit") {
		data = {action:"edit",name:name,exercises:exercises,oName:$("#editor").data("name")};
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
	
	$("#editor").hide();
	$("#left, #right").show();
	
	$("#workout-content").sortable().disableSelection();
}


var jBigItem = $("<div>").addClass("big-item")
					.append($("<p>").html("Exercice vide"))
					.append($("<input type='text'>").val("00:00:00")
													.prop("pattern", "[0-9]{2}:[0-9]{2}:[0-9]{2}"))
					.append($("<input type='button'>").val("X"));

$(document).ready(function(){
	
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
	
	// Ajout élément workout
	$("#editor").on("click", "#add", function () {
		name = $("#add-exercise").find(":selected").val();
		dura = $("#add-duration").val();
		var jBIClone = jBigItem.clone();
		jBIClone.find("p").html(name);
		jBIClone.find("input[type=text]").val(dura);
		$("#workout-content").append(jBIClone);
	});
	
	// Suppression élément workout
	$("#editor").on("click", "input[type=button]", function () {
		$(this).closest(".big-item").remove();
	});
	
	// Gérer le passage en mode affichage
	$("#editor").on("click", "#can", function() {
		$("h1").html("Workout");
		init();
	});
	
	$("#editor").on("click", "#val", function() {
		$("h1").html("Workout");
		addWorkout();
	});
	
	$("#editor").on("click", "#del", function() {
		$("h1").html("Workout");
		delWorkout();
	});
	
});

