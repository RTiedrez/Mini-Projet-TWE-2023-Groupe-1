<!-- Auteur : Lucas SALAND -->
<?php
include_once "libs/maLibForms.php";

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=signup");
	die("");
}

if($err = valider("error")) {
	echo "<div id=\"err-div\" class=\"centered\">";
	switch($err)
	{
		case "err_loginUsed":
			echo "<p>Ce pseudo existe déjà</p>";
			break;
		case "err_badConfirm":
			echo "<p>Erreur sur la confirmation du mot de passe</p>";
			break;
		case "err_noPassword":
			echo "<p>Veuillez renseigner un mot de passe</p>";
			break;
		case "err_noLogin":
			echo "<p>Veuillez renseigner un pseudo</p>";
			break;
		case "err_passwordLength":
			echo "<p>Le mot de passe doit faire moins de 32 caractères</p>";
			break;
		case "err_loginLength":
			echo "<p>Le pseudo doit faire moins de 16 caractères</p>";
			break;
	}
	echo "</div>";
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		console.log("ready");
		$("input[type='radio']").on("click",function(event) {
			console.log("change");
			console.log($(this).prop("checked"));
			if($(this).prop("checked")) {
				$(this).css("color","red");//NE MARCHE PAS !!!!!!!!!!!
			} else {
				$(this).css("color","white");
			}
		});
	});
</script>

<div id="signup-div" class="rounded-box black-transparent-background centered">
<form action="controleur.php" method="POST">
	<input type="text" class="connection-text-input" name="login" placeholder="pseudo"/> <br/>
	<input type="password" class="connection-text-input" name="passe" placeholder="Mot de passe"/> <br/>
	<input type="password" class="connection-text-input" name="confirm_passe" placeholder="Confirmer mot de passe"/> <br/>
	<input type="radio" name="userType" value="utilisateur" id="utilisateur" checked>
	<label for="utilisateur">utilisateur</label>
	<input type="radio" name="userType" value="coach" id="coach">
	<label for="coach">coach</label> <br/>
	<input type="submit" class="form-button" name="action" value="Annuler"/>
	<input type="submit" class="form-button" name="action" value="SIGN UP"/>
</form>	
</div>