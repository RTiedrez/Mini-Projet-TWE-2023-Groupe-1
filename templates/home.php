<!-- Auteur : Lucas SALAND -->
<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=home");
	die("");
}
?>

<div id="home-div" class="black-transparent-background rounded-box">
	<h1><span class="red">READY</span> </br> TO LIFT ?</h1>
	<p>
		<span class="material-symbols-outlined" style="color: red;">
		done
		</span>
		Pour les <span class="red">sportifs</span>
	</p>
	<p>
		<span class="material-symbols-outlined" style="color: red;">
			done
		</span>
		Pour les <span class="red">coachs</span>
	</p>
</div>
