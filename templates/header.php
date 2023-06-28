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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro&display=swap" rel="stylesheet">
	<script src="js/jquery-3.7.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			// Colorier le lien correspondant à la page active 
			var url = window.location.href;
			var page = url.split("view=")[1];
			if (page == undefined) {
				page = "home";
			}
			$("#"+page).addClass("selected");

			$("#menu-image").click(function() {
				$("#dropdown").toggle();
			});

			// Cliquer sur le logo redirige vers l'accueil
			$("#logo").click(function() {
				window.location.href = "index.php?view=home";
			});
			
		});
	</script>

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
		#logo:hover {
			cursor: pointer;
		}
		#banniere {
			background-color: rgba(0,0,0,0.6);
			padding: 10px;
			margin-bottom: 10px;
			height: 100px;
		}
		#logo {
			float: left;
			margin: -14px;
		}
		#liens {
			float: left;
			margin-top: 30px;
		}
		.lien {
			font-size: 25px;
			font-weight: bold;
			font-family: "Roboto";
			color: #FFFFFF;
			margin-left: 64px;
		}
		.selected {
			color: #FF0000;
		}
		#signs {
			position: absolute;
			right: 0px;
			top: 48px;
		}
		.sign {
			margin-right: 64px;
			font-size: 32px;
			font-weight: bold;
			font-family: "Bebas Neue";
			padding: 8px 40px;
			border-radius: 22px;
			text-decoration: none;
		}
		#signin {
			background-color: #FF0000;
			color: #FFFFFF
		}
		#signup {
			background-color: #FFB3B3;
			color: #000000;
		}
		#menu-image:hover {
			cursor: pointer;
		}
		#menu {
			position: absolute;
			right: 20px;
			top: 24px;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			right: -12px;
			background-color: #D9D9D9;
			padding: 8px 40px;
			border-radius: 25px;
			z-index: 1;
		}
		.dropdown-content a {
			font-family: "AnonymousPro";
			font-size: 25;
			font-weight: bold;
			color: #000000;
			padding: 10px 12px;
			text-decoration: none;
			min-width: 128px;
			display: block;
		}
	</style>

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
			} else {
				echo "<a id=\"coach_dashboard\" class=\"lien\" href=\"index.php?view=coach_dashboard\">Dashboard</a>";
				echo "<a id=\"coach_exercices\" class=\"lien\" href=\"index.php?view=coach_exercices\">Exercices</a>";
				echo "<a id=\"coach_workouts\" class=\"lien\" href=\"index.php?view=coach_workouts\">Workouts</a>";
				echo "<a id=\"coach_groups\" class=\"lien\" href=\"index.php?view=coach_groups\">Groups</a>";
				echo "<a id=\"coach_requests\" class=\"lien\" href=\"index.php?view=coach_requests\">Requests</a>";
			}
		} else {
			// S'il n'est pas connecté, il n'a accès qu'à la page d'accueil
				echo "<a id=\"home\" class=\"lien\" href=\"index.php?view=home\">Accueil</a>";
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
			echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
			}
		?>
	</div>
</div>
</div>
</body>
<!-- **** F I N **** B O D Y **** -->
