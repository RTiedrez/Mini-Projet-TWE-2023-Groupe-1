<!-- Auteur : Lucas SALAND -->
<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=signin");
	die("");
}

if($err = valider("error")) {
	echo "<div id=\"err-div\" class=\"centered\">";
	switch($err){
		case "err_noPassword":
			echo "<p>Veuillez renseigner un mot de passe</p>";
			break;
		case "err_noLogin":
			echo "<p>Veuillez renseigner un pseudo</p>";
			break;
		case "err_loginOrPassword":
			echo "<p>Pseudo ou mot de passe incorrect</p>";
			break;
	}
	echo "</div>";
}
?>

<div id="signin-div" class="rounded-box black-transparent-background centered">
<form action="controleur.php" method="POST">
	<input type="text" class="connection-text-input" name="login" placeholder="pseudo"/> <br/>
	<input type="password" class="connection-text-input" name="passe" placeholder="Mot de passe"/> <br/>
	<input type="submit" class="form-button red-background" name="action" value="Annuler"/>
	<input type="submit" class="form-button red-background" name="action" value="SIGN IN"/>
</form>	
</div>

