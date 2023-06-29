<?php
// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_groups");
	die("");
}
?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/coach-groups.js"></script>

<!------------------------------------------------------------->

<style src="css/style.css"></style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Groups</h1>
	
	<div id="editor">
		<div id="name-editor"></div>
		<div id=grid>
			<div id="user-list">
				<ul id="left-list" class="sortable-list"></ul>
			</div>
			<div id="group-editor">
				<ul id="right-list" class="sortable-list"></ul>
			</div>
		</div>
		<input id=val type=button value=Validate>
		<input id=del type=button value=Delete>
		<input id=can type=button value=Cancel>
	</div>
	
	<div id="left" class="column"></div>
	<div id="right" class="column"></div>
	
</div>
