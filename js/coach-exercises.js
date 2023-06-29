// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

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
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"editor",name:name},
		success: function(result) {
			r = JSON.parse(result);
			$('#property-editor').html(r["property-editor"]);
			if(r["current-media"] != false) {
				$('#drop-zone').html(r["current-media"]);
				$("#drop-zone").data("media",r["current-media"]);
				$("#drop-zone").css('border-color', 'blue');
			}
			else {
				$("#drop-zone").data("media",false);
			}
		}
	});
	$("#editor").show()
	$("#left, #right").hide();
}

function addExercise() {
	var name = $("#edit-name").val();
	var desc = $("#edit-desc").val();
	var media = $("#drop-zone").data("media");
	
	var formData = new FormData();
	formData.append('name', name);
	formData.append('desc', desc);
	formData.append('media', media);
	
	if ((typeof media) == "object") {
		formData.append("hasmedia", true);
	}
	else {
		formData.append("hasmedia", false);
	}
	
	if ($("#editor").data("mode") == "add") {
		formData.append('action', 'add');
	}
	if ($("#editor").data("mode") == "edit") {
		formData.append('action', 'edit');
		var oName = $("#editor").data("name");
		formData.append('oName', oName);
	}
	
	$.ajax({
		url: url,
		method: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		success: function(result) {
			console.log(result);
		}
	});
	
	init();
}

function delExercise() {
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
	showExerciseList();
	$("#editor").hide();
	$("#left, #right").show();
}

$(document).ready(function(){
	
	init();
	
	$("#left").on("click", ".item", function() {
		$(".item-selected").removeClass().addClass("item");
		$(this).removeClass().addClass("item-selected");
		var name = $(this).text();
		showExercise(name);
	});
	
	// Gérer le passage en mode ajout
	$("#content").on("click", "#left .item-add", function() {
		$("h1").html("Add a exercise");
		$("#editor").data("mode","add");
		$("#editor").data("name","");
		$("#del").hide();
		loadEditor("create-new-exercise");
	});
	
	// Gérer le passage en mode édition
	$("#content").on("click", "#right .item-add", function() {
		var name = $(".item-selected").text();
		$("h1").html("Edit an exercise");
		$("#editor").data("mode","edit");
		$("#editor").data("name",name);
		$("#del").show();
		loadEditor($(".item-selected").text());
	});
	
	
	// Gérer le passage en mode affichage
	$("#editor").on("click", "#can", function() {
		$("h1").html("Exercise");
		init();
	});
	
	$("#editor").on("click", "#val", function() {
		$("h1").html("Exercise");
		addExercise();
	});
	
	$("#editor").on("click", "#del", function() {
		$("h1").html("Exercise");
		delExercise();
	});
	
	// Gérer la drop zone
	$("#drop-zone").on("dragover", function(r) {
		r.preventDefault();
		$("#drop-zone").css('border-color', 'red');
	});
	
	$("#drop-zone").on("dragleave", function(r) {
		r.preventDefault();
		$("#drop-zone").css('border-color', 'rgb(200,200,200)');
	});
	
	$("#drop-zone").on("drop", function(r) {
		r.preventDefault();
		var file = r.originalEvent.dataTransfer.files[0];
				
		if (file.type.match("image.*|video.*")) {
			$("#drop-zone").css('border-color', 'blue');
			$("#drop-zone").html(file["name"]);
			$("#drop-zone").data("media",file);
		}
	});
	
	$("#editor").on("click", "#rem", function() {
		$("#drop-zone").css('border-color', 'rgb(200,200,200)');
		$("#drop-zone").data("media",false);
		$("#drop-zone").html("Drop an image or a video");
	});
});

