<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_dashboard");
	die("");
}
?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>

<script>

var url = "libs/search_dashboard.php"

function loadContent() {
	$('#imgLoad').hide();
	$.ajax({
		url: url,
		method: 'POST',
		data: {name:""},
		success: function(result) {
			$('#searchResults').html(result);
		}
	});
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	loadContent();
	
	// Affichage dynamique des utilisateurs
	$('#searchUser').keyup(function() {
		$('#imgLoad').show();
		var name = $(this).val();
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {name:name},
			success: function(result) {
				if (result != $('#searchResults').html()) {
					$('#searchResults').html(result);
				}
			}
		});
		$('#imgLoad').hide();
	});
	
	$("#searchResults").on("click", ".user", function() {
		var clickedUser = $(this).text();
		console.log("Clique sur : ", clickedUser);
	});
});

</script>

<!------------------------------------------------------------->

<style>

div {
	color:white;
}

body {
	background-image: url('ressources/background.jpg');
	background-position: top center;
	padding:10px;
}

#content {
	background-color:rgba(10,10,10,.5);
	padding:10px;
	margin-top:10px;
	border-radius:20px;
	min-height: 50vh;
}

.user {
	background-color:rgb(200,200,200);
	color:black;
	padding:10px;
	margin:10px;
	border-radius:10px;
	cursor:pointer;
}

</style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Dashboard</h1>
	Chercher un de mes élèves : <input type="text" id="searchUser">
	<img id="imgLoad" src="ressources/ajaxLoader2.gif"/>
	<div id="searchResults"></div>

</div>
