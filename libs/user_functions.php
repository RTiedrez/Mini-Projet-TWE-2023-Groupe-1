<!-- Auteur : Oussama Mounajjim -->
<?php

include_once("maLibSQL.pdo.php");
include_once("modele.php");
include("config.php");

function getGroup($idUser){
    $SQL = "SELECT idGroup FROM user_group WHERE idUser = $idUser LIMIT 1";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// print_r(getGroup($idUser));
// echo getGroup(7)[0]['idGroup'];

function getWorkouts($idUser){
    $idGroup = getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT idWorkout FROM group_workout WHERE date < CURDATE() and idGroup = $idGroup";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// print_r(getWorkouts($idUser));

function getLastActivity($idUser){
    $SQL = "SELECT title, description, fichier, nbRep, performances.date FROM exercises, performances WHERE exercises.id = idExercice and idUser = $idUser and date < CURDATE() LIMIT 3";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}


// print_r(getLastActivity($idUser));
function UserCoach($idUser){
    if(!empty(getCoach($idUser))){
        return True;
    }
    return False;
}
function getCoach($idUser){
    if (empty(getGroup($idUser))) return [];
    $idGroup=getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT users.login FROM users, `groupes` WHERE `groupes`.id = $idGroup and users.isCoach = 1 and users.id = `groupes`.idCoach";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}

// print_r(getCoach($idUser));

function getListExercices($idUser){
    if (empty(getGroup($idUser))) return [];
    $idGroup = getGroup($idUser)[0]['idGroup'];
    $SQL = "SELECT exercises.title, workout_exercise.duration FROM exercises, `workout_exercise`, `group_workout` WHERE group_workout.date < CURDATE() and group_workout.idWorkout = workout_exercise.idWorkout and workout_exercise.idExercise = exercises.id and group_workout.idGroup = $idGroup";
    $result = parcoursRs(SQLSelect($SQL));
    return $result;
}



function getListCoach(){
    $SQL="SELECT login FROM users WHERE isCoach=1 ;";
    $result=parcoursRs(SQLSelect($SQL));
    return $result;
}

function SendInvitation($idUser,$idCoach){
    $SQL = "INSERT into requests (idUser, idCoach) values ($idUser,$idCoach);";
    return SQLInsert($SQL);
}
// print_r(getListExercices($idUser));


?>
