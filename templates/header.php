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
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
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
		@font-face {
			font-family: "Roboto";
			src: url("ressources/Roboto/Roboto-Regular.ttf");
		}
		@font-face {
			font-family: "BebasNeue";
			src: url("ressources/Bebas_Neue/BebasNeue-Regular.ttf");
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
			font-family: "BebasNeue";
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
	</style>
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<div id="banniere">

	<div id="logo">
		<!-- TODO : rendre l'image cliquable -->
		<img src="ressources/Logo.png" alt="Logo de Gigachad Workout"/>
	</div>

	<div id="liens">

		<a class="lien" href="index.php?view=home">Accueil</a>
		<?php
		// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
		if (valider("connecte","SESSION")) {
			if (!valider("isCoach","SESSION")) {
				echo "<a class=\"lien\" href=\"index.php?view=user\">Dashboard</a>";
			} else {
				echo "<a class=\"lien\" href=\"index.php?view=coach_dashboard\">Dashboard</a>";
				echo "<a class=\"lien\" href=\"index.php?view=coach_exercices\">Exercices</a>";
				echo "<a class=\"lien\" href=\"index.php?view=coach_workouts\">Workouts</a>";
				echo "<a class=\"lien\" href=\"index.php?view=coach_groups\">Groups</a>";
				echo "<a class=\"lien\" href=\"index.php?view=coach_requests\">Requests</a>";
			}
		}
		?>
	</div>

	<div id="signs">
		<!-- TODO : logo en haut à droite -->
		<?php
		if (!valider("connecte","SESSION")) {
			echo "<a class=\"sign\" id=\"signin\" href=\"index.php?view=signin\">SIGN IN</a>";
			echo "<a class=\"sign\" id=\"signup\" href=\"index.php?view=signup\">SIGN UP</a>";
		}
		?>
	</div>

</div>
</body>
<!-- **** F I N **** B O D Y **** -->

