<?php
// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_requests");
	die("");
}
?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/coach-requests.js"></script>

<!------------------------------------------------------------->

<style src="css/style.css"></style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Requests</h1>
	<div id="search-bar">
		Look for a request : <input type="text" id="search-requesters">
	</div>
	<img id="img-load" src="ressources/ajaxLoader2.gif"/>
	<div id="search-results"></div>

</div>
