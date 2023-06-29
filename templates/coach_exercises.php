<?php
// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=coach_exercises");
	die("");
}
?>

<!------------------------------------------------------------->

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/coach-exercises.js"></script>

<!------------------------------------------------------------->

<style src="css/style.css"></style>

<!------------------------------------------------------------->

<div id="content">
	<h1>Exercises</h1>
	
	<div id="editor">
		<div id=grid>
			<div id="property-editor"></div>
			<div id="media">
				<div id="drop-zone">Drop an image or a video</div>
				<input id=rem type=button value=Remove>
			</div>
		</div>
		<input id=val type=button value=Validate>
		<input id=del type=button value=Delete>
		<input id=can type=button value=Cancel>
	</div>
	
	<div id="left" class="column"></div>
	<div id="right" class="column"></div>
	
</div>
