<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=signin");
	die("");
}

if($err = valider("error")) {
	switch($err){
		case "err_noPassword":
			echo "<div id=\"errLoginDiv\">";
			echo "<p>Veuillez renseigner un mot de passe</p>";
			echo "</div>";
			break;
		case "err_noLogin":
			echo "<div id=\"errLoginDiv\">";
			echo "<p>Veuillez renseigner un pseudo</p>";
			echo "</div>";
			break;
		case "err_loginOrPassword":
			echo "<div id=\"errLoginDiv\">";
			echo "<p>Pseudo ou mot de passe incorrect</p>";
			echo "</div>";
			break;
	}
}
?>

<div id="signinDiv">
<form action="controleur.php" method="POST">
	<input type="text" name="login" placeholder="pseudo"/> <br/>
	<input type="password" name="passe" placeholder="Mot de passe"/> <br/>
	<input type="submit" name="action" value="Annuler"/>
	<input type="submit" name="action" value="SIGN IN"/>
</form>	
</div>
