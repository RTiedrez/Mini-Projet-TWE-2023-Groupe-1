// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

var url = 'libs/search_groups.php';

function showGroup(name) {
	$.ajax({
		url: url,
		method: 'POST',
		data: {action:"group",name:name},
		success: function(result) {
			if (result != $('#right').html()) {
				$('#right').html(result);
			}
		}
	});
}

function selected(id) {
	showGroup($(".item").eq(id).text());
	$(".item").eq(id).removeClass().addClass("item-selected");
}

function showGroupList(id) {
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
			$('#name-editor').html(r["name-group"]);
			$('#left-list').html(r["free-users"]);
			$('#right-list').html(r["group-users"]);
		}
	});
	
	$("#editor").show()
	$("#left, #right").hide();
}

function addGroup() {
	var users = [];
	var name = $("#edit-name").val();
	
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

function delGroup() {
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
	showGroupList();
	
	$("#editor").hide()
	$("#left, #right").show();
	
	$("#right-list").sortable({connectWith: "ul"}).disableSelection();
	$("#left-list").sortable({connectWith: "ul"}).disableSelection();
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	console.log("Loaded");
	init();
	
	$("#left").on("click", ".item", function() {
		$(".item-selected").removeClass().addClass("item");
		$(this).removeClass().addClass("item-selected");
		var name = $(this).text();
		showGroup(name);
	});
	
	
	// Gérer le passage en mode ajout
	$("#content").on("click", "#left .item-add", function() {
		$("h1").html("Add a group");
		$("#editor").data("mode","add");
		$("#editor").data("name","");
		$("#del").hide();
		loadEditor("create-new-group");
	});
	
	// Gérer le passage en mode édition
	$("#content").on("click", "#right .item-add", function() {
		var name = $(".item-selected").text();
		$("h1").html("Edit a group");
		$("#editor").data("mode","edit");
		$("#editor").data("name",name);
		$("#del").show();
		loadEditor($(".item-selected").text());
	});
	
	
	// Gérer le passage en mode affichage
	$("#content").on("click", "#can", function() {
		$("h1").html("Groups");
		init();
	});
	
	$("#content").on("click", "#val", function() {
		$("h1").html("Groups");
		addGroup();
	});
	
	$("#content").on("click", "#del", function() {
		$("h1").html("Groups");
		delGroup();
	});
	
});

