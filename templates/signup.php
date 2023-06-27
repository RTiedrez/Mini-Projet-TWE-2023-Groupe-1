<?php
include_once "libs/maLibForms.php";

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=signup");
	die("");
}

if($err = valider("error")) {
	switch($err)
	{
		case "err_loginUsed":
			echo "<div id=\"errLoginDiv\">";
			echo "<p>Ce pseudo existe déjà</p>";
			echo "</div>";
			break;
		case "err_badConfirm":
			echo "<div id=\"errLoginDiv\">";
			echo "<p>Erreur sur la confirmation du mot de passe</p>";
			echo "</div>";
			break;
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
	}
}

?>
<div id="signupDiv" class="rounded-box">
<form action="controleur.php" method="POST">
	<input type="text" name="login" placeholder="pseudo"/> <br/>
	<input type="password" name="passe" placeholder="Mot de passe"/> <br/>
	<input type="password" name="confirm_passe" placeholder="Confirmer mot de passe"/> <br/>
	<input type="radio" name="userType" value="utilisateur" id="utilisateur" checked>
	<label for="utilisateur">utilisateur</label>
	<input type="radio" name="userType" value="coach" id="coach">
	<label for="coach">coach</label> <br/>
	<input type="submit" name="action" value="Annuler"/>
	<input type="submit" name="action" value="SIGN UP"/>
</form>	
</div>