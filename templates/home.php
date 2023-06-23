<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=home");
	die("");
}

?>

<div id="corps">

<h1>Accueil</h1>

Home

</div>
