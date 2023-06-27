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
	<link rel="stylesheet" type="text/css" href="css/style.css?v=1"> <!-- ?v=1 oblige le navigateur à recharger la feuille de style, sinon il faut vider le cache pour avoir la feuille de style mise à jour -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<div id="banniere">

<!-- <div id="logo">
<img src="ressources/ec-lille.png" alt="Logo de Centrale Lille"/>
</div> -->

<a href="index.php?view=home">Home</a>
<a href="index.php?view=user">User</a>

<?php
// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
if (!valider("connecte","SESSION")) {
	echo "<a href=\"index.php?view=signin\">SIGN IN</a>";
	echo " ";
	echo "<a href=\"index.php?view=signup\">SIGN UP</a>";
} else {
	echo "<a href=\"controleur.php?action=Logout\">Se déconnecter</a>";
}
?>

</div>