<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=home");
	die("");
}

?>

<div id="corps">

<h1>Home</h1>

There is nothing to display here.

</div>
