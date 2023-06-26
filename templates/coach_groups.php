<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_groups");
	die("");
}

?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>

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
			$('#nameEditor').html(r.nameGroup);
			$('#left-list').html(r.freeUsers);
			$('#right-list').html(r.groupUsers);
		}
	});
	
	$("#editor").show()
	$("#left, #right").hide();
}

function addGroup() {
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
	
	
	// Gérer le passage en mode édition
	$("#content").on("click", "#left .item-add", function() {
		$("h1").html("Add a group");
		$("#editor").data("mode","add");
		$("#editor").data("name","");
		loadEditor("create-new-group");
	});
	
	$("#content").on("click", "#right .item-add", function() {
		var name = $(".item-selected").text();
		$("h1").html("Edit a group");
		$("#editor").data("mode","edit");
		$("#editor").data("name",name);
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

.group {
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

#group {
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

#groupEditor, #dragUserList {
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
	<h1>Groups</h1>
	
	<div id="editor">
		<div id="nameEditor"></div>
		<div id="dragUserList">
			<ul id="left-list" class="sortable-list">
			</ul>
		</div>
		<div id="groupEditor">
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
