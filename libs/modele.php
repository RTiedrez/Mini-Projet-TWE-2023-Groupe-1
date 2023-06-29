<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
 (chmod +rw)*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)

include_once("maLibSQL.pdo.php"); // include_once vérifie que la library n'a pas déjà été include (à privilégier)

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	$SQL="SELECT id FROM users WHERE login='$login' AND password='$passe'";
	return SQLGetChamp($SQL);
}

function isCoach($idUser)
{
	// vérifie si l'utilisateur est un coach
	$SQL="SELECT isCoach FROM users WHERE id='$idUser'";
	$coach = SQLGetChamp($SQL);
	if($coach && $coach == 1) {
		return true;
	} else {
		return false;
	}
}

function verifLoginBdd($login) 
{
	// vérifie qu'un login existe dans la base de donnée
	// renvoie l'id de l'utilisateur ayant ce login s'il existe
	// renvoie false si le login n'existe pas
	$SQL="SELECT id FROM users WHERE login='$login'";
	return SQLGetChamp($SQL);
}

function ajouterUser($login,$passe,$isCoach)
{
	$SQL = "INSERT INTO users (isCoach, login, password) VALUES ($isCoach,'$login','$passe')";
	return SQLInsert($SQL);
}

function SendInvitation($idUser,$idCoach){
    $SQL = "INSERT INTO requests (idUser, idCoach) VALUES ($idUser,$idCoach);";
    return SQLInsert($SQL);
}
?>