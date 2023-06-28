<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)

include_once("maLibSQL.pdo.php"); // include_once vérifie que la library n'a pas déjà été include (à privilégier)

function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 

	$SQL="SELECT id,pseudo,blacklist,admin,couleur from users";
	if ($classe == "bl") $SQL .= " WHERE blacklist=1"; // /!\ .= en PHP !!!!!
	if ($classe == "nbl") $SQL .= " WHERE blacklist=0";

	// die($SQL); // Bonne pratique
	return parcoursRs(SQLSelect($SQL));

}

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

function ajouterUser($login,$passe,$isCoach)
{
	$SQL = "INSERT INTO users (isCoach, login, password) VALUES ($isCoach,'$login','$passe')";
	return SQLInsert($SQL);
}
?>