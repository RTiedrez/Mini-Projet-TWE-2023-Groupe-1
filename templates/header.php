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
			color: #FFFFFF;
			padding: 10px;
			margin-bottom: 10px;
			height: 100px;
		}
		#logo {
			float: left;
			margin-right: 10px;
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

<a href="index.php?view=home">Accueil</a>

<?php
// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
if (!valider("connecte","SESSION")) {
	echo "<a href=\"index.php?view=signin\">SIGN IN</a>";
	echo " ";
	echo "<a href=\"index.php?view=signup\">SIGN UP</a>";
} else {
	if (!valider("isCoach","SESSION")) {
		echo "<a href=\"index.php?view=user\">Dashboard</a>";
	} else {
		echo "<a href=\"index.php?view=coach_dashboard\">Dashboard</a>";
		echo "<a href=\"index.php?view=coach_exercices\">Exercices</a>";
		echo "<a href=\"index.php?view=coach_workouts\">Workouts</a>";
		echo "<a href=\"index.php?view=coach_groups\">Groups</a>";
		echo "<a href=\"index.php?view=coach_requests\">Requests</a>";
	}
}
?>

</div>
