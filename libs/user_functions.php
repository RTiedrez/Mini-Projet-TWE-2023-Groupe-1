<!-- Auteur : Oussama Mounajjim -->
<?php

include_once("maLibSQL.pdo.php");
include_once("modele.php");
include("config.php");

// Fonction qui récupère le nom d'utilisateur en fonction de l'ID de l'utilisateur
function getUsernameById($idUser){
    $SQL = "SELECT login from users WHERE id=$idUser";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui récupère le groupe d'un utilisateur
function getGroup($idUser){
    $SQL = "SELECT idGroup FROM user_group WHERE idUser = $idUser LIMIT 1";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui récupère les entraînements d'un utilisateur
function getWorkouts($idUser){
    $idGroup = getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT idWorkout FROM group_workout WHERE date < CURDATE() and idGroup = $idGroup";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui récupère les dernières activités d'un utilisateur
function getLastActivity($idUser){
    $SQL = "SELECT title, description, fichier, nbRep FROM exercises, performances WHERE exercises.id = idExercice and idUser = $idUser and date < CURDATE() LIMIT 3";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui vérifie si un utilisateur est un coach
function UserCoach($idUser){
    if(!empty(getCoach($idUser))){
        return true;
    }
    return false;
}

// Fonction qui récupère le coach d'un utilisateur
function getCoach($idUser){
    if (empty(getGroup($idUser))) return [];
    $idGroup=getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT users.login FROM users, `groupes` WHERE `groupes`.id = $idGroup and users.isCoach = 1 and users.id = `groupes`.idCoach";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui récupère la liste des exercices d'un utilisateur
function getListExercices($idUser){
    if (empty(getGroup($idUser))) return [];
    $idGroup = getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT exercises.title, workout_exercise.duration FROM exercises, `workout_exercise`, `group_workout` WHERE group_workout.date < CURDATE() and group_workout.idWorkout = workout_exercise.idWorkout and workout_exercise.idExercise = exercises.id and group_workout.idGroup = $idGroup";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui récupère la liste des coaches
function getListCoach(){
    $SQL="SELECT login FROM users WHERE isCoach=1 ;";
    $result=parcoursRs(SQLSelect($SQL));
    return $result;
}

// Fonction qui envoie une invitation d'entraînement à un coach
function SendInvitation($idUser,$idCoach){
    $SQL = "INSERT into requests (idUser, idCoach) values ($idUser,$idCoach);";
    return SQLInsert($SQL);
}

// Fonction qui recherche un coach par son nom
function findCoachByName($nameCoach){
    $SQL="SELECT id FROM users WHERE login='$nameCoach';";
    $result= parcoursRs(SQLSelect($SQL));
    return $result;
}

?>
