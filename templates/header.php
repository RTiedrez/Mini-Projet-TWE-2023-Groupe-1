<!-- Auteur : Roman TIEDREZ -->

<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// On envoie l'entête Content-type correcte avec le bon charset
header('Content-Type: text/html;charset=utf-8');

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
	<title>Gigachad Workout</title>
	<link rel="icon" type="image/x-icon" href="ressources/favicon.ico">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="js/script.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			colorierLiens();

			// Cliquer sur le logo redirige vers l'accueil
			$("#logo").click(function() {
				window.location.href = "index.php?view=home";
			});


			$("#menu-image").click(function() {
        		$("#dropdown").toggle();
    		});

		});
	</script>


</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<div id="banniere">


	<div id="logo">
		<img src="ressources/Logo.png" alt="Logo de Gigachad Workout"/>
	</div>

	<div id="liens">

		<?php
		// Si l'utilisateur est connecté, on affiche les liens vers ses pages de l'utilisateur
		// Selon qu'il soit coach ou non, on affiche des liens différents
		if (valider("connecte","SESSION")) {
			if (!valider("isCoach","SESSION")) {
				echo "<a id=\"user\" class=\"lien\" href=\"index.php?view=user\">Dashboard</a>";
				echo "<a id=\"user_workout\" class=\"lien\" href=\"index.php?view=user_workout\">Workout</a>";
			} else {
				echo "<a id=\"coach_dashboard\" class=\"lien\" href=\"index.php?view=coach_dashboard\">Dashboard</a>";
				echo "<a id=\"coach_exercises\" class=\"lien\" href=\"index.php?view=coach_exercises\">Exercises</a>";
				echo "<a id=\"coach_workouts\" class=\"lien\" href=\"index.php?view=coach_workouts\">Workouts</a>";
				echo "<a id=\"coach_groups\" class=\"lien\" href=\"index.php?view=coach_groups\">Groups</a>";
				echo "<a id=\"coach_requests\" class=\"lien\" href=\"index.php?view=coach_requests\">Requests</a>";
			}
		} else {
			// S'il n'est pas connecté, il n'a accès qu'à la page d'accueil
			echo "<a id=\"home\" class=\"lien\" href=\"index.php?view=home\">Home</a>";
		}
		?>
	</div>

	<div id="signs">
		<?php
		// Si l'utilisateur n'est pas connecté, on affiche aussi les liens vers les pages de connexion et d'inscription
		if (!valider("connecte","SESSION")) {
			echo "<a class=\"sign\" id=\"signin\" href=\"index.php?view=signin\">SIGN IN</a>";
			echo "<a class=\"sign\" id=\"signup\" href=\"index.php?view=signup\">SIGN UP</a>";
		}
		?>
	</div>

	<div id="menu">

		<?php
		// Si l'utilisateur est connecté, on affiche le menu contextuel
		if (valider("connecte","SESSION")) {
			echo "<img id=\"menu-image\" src=\"ressources/lucas.png\" alt=\"Bouton menu contextuel\"/>";
			echo "<div id=\"dropdown\" class=\"dropdown-content\">";
			if (!valider("isCoach","SESSION")) {
				echo "<a href=\"index.php?view=user\">Dashboard</a>";
			} else {
				echo "<a href=\"index.php?view=coach_dashboard\">Dashboard</a>";
			}
			echo "<a href=\"controleur.php?action=Logout\">Déconnexion</a>";
			}
		?>
	</div>
</div>
</div>
</body>
<!-- **** F I N **** B O D Y **** -->
