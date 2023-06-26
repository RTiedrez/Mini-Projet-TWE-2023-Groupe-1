<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_requests");
	die("");
}
?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>

<script>

function loadContent() {
	$('#imgLoad').hide();
	$.ajax({
		url: 'libs/searchRequests.php',
		method: 'POST',
		data: {name:"",action:"list"},
		success: function(result) {
			$('#searchResults').html(result);
		}
	});
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	loadContent();
	
	// Affichage dynamique des utilisateurs
	$('#searchRequesters').keyup(function() {
		$('#imgLoad').show();
		var name = $(this).val();
		
		$.ajax({
			url: 'libs/searchRequests.php',
			method: 'POST',
			data: {name:name,action:"list"},
			success: function(result) {
				if (result != $('#searchResults').html()) {
					$('#searchResults').html(result);
				}
			}
		});
		$('#imgLoad').hide();
	});
	
	$("#searchResults").on("click", ".accept", function() {
		var clickedUser = $(this).closest(".item").find('.requester').text();
		console.log("Accepte : ", clickedUser);
		$.ajax({
			url: 'libs/searchRequests.php',
			method: 'POST',
			data: {name:clickedUser,action:"accept"},
			success: function(result) {
				console.log("Accepted :", result);
				loadContent();
			}
		});
	});
	
	$("#searchResults").on("click", ".decline", function() {
		var clickedUser = $(this).closest(".item").find('.requester').text();
		console.log("Refuse : ", clickedUser);
		$.ajax({
			url: 'libs/searchRequests.php',
			method: 'POST',
			data: {name:clickedUser,action:"decline"},
			success: function(result) {
				console.log("Accepted :", result);
				loadContent();
			}
		});
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
	height:100%;
}

.item{
	
}

.requester {
	background-color:rgb(200,200,200);
	color:black;
	padding:10px;
	margin:10px;
	border-radius:10px;
}

.images {
	float:right;
}

.images img {
	margin-left:10px;
	cursor:pointer;
}

</style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Requests</h1>
	Chercher un demandeur : <input type="text" id="searchRequesters">
	<img id="imgLoad" src="ressources/ajaxLoader2.gif"/>
	<div id="searchResults"></div>

</div>
