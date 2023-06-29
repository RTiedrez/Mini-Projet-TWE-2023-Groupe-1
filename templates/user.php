<!-- Auteur : Oussama Mounajjim -->

<!----- Importation des bibliothéque nécéssaire et insertion du header ----->
<?php
include_once("libs/user_functions.php");

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=user");
	die("");
}

// Recupération de l'id du user pour la manipulation des differents sections
$idUser = valider("idUser","SESSION");

?>

<!------------------------------------------------------------->
<!DOCTYPE html>
<html>

<!-- On commence à récuperer le fichier du style ainsi que création des differents
styles pour rassemblé au Mock-up crée et faciliter l'intéraction avec la page user -->

  <style src="css/style.css"></style>
  <style>
    #title-page-user{
      color : white;  
    }
    .form{
      background-color: black;  
      opacity: 0.8;
      color: white;
      width: 400px;
      padding: 50px;
      text-align: center;
      border-radius: 10px;
      margin: 5px;
      display: inline-block;
    }
    .page{
      border-radius: 19px;
    }

    #dashboard-user{
      display: block;
    }
    #lastActivity {
      text-align:left;
    }
    .titre {
      font-weight: bold;
      color: red;
    }
    #select-field{
      padding: 10px;
      border-radius: 3px;
    }
  </style>

<!------------------------------------------------------------->


<body>
  <!-- Buttons pour se déplacer entre les differents section de la page avant la création du header -->


  <!-- <input type="button" id="to_dashboard" value="dashboard" onclick="to_dashboard()">
  <input type="button" id="to_workout" value="workout" onclick="to_workout()"> -->



<div id="dashboard-user" class="page">

  <center>
  
  <!-- On utilise des requetes en php pour afficher le pseudo de l'utilisateur en utilisant la fonction
  getUsernameById crée dans user_functions.php -->

  <h1 id="title-page-user" >
    <?php
    $username = getUsernameById($idUser)[0]['login']; 
    echo "Welcome $username "; 
    ?>
    </h1>

    <!-- Maintenant on récupére les exercices effectué par l'utilisateur durant les 5 jours précedents
    On a utiliser le fonction getLastActivity pour récuperer le titre, la description, l'image et le
    nombre de répétition -->


  <div id="last-week-activity"  class="form" >

  <?php 

  $lastactivity = getLastActivity($idUser);

  echo "<div id='lastActivity'><center><h2>Last Week Activity</center></h2>";


  foreach ($lastactivity as $activity) {


    $title = $activity['title'];
    $description = $activity['description'];
    $image = $activity['fichier'];
    $nbrep = $activity['nbRep'];


    if(!empty($title)){
      echo "<h2><label class='titre'>Workout's Title:</label> $title</h2><br>";
    }

    if(!empty($description)){
      echo "<label><label class='titre'>Workout's Desciption:</label> $description</label><br>";
    }

    if(!empty($image)){
      echo "<label><label class='titre'>Workout's Image:</label> $image</label><br><br>";
    }

    if(!empty($nbrep)){
      echo "<label><label class='titre'>Your reps:</label> $nbrep</label><br>";
    }

  }

  echo "</div>";

  if (empty($lastactivity)){
    echo "<h2>No workout has been done yet</h2><br>";

}

?>

</div>

<!-- Cette div est pour les workouts qui suit, on a developpé une focntion getListExercices() qui revient la duration
et le titre de chaque exercice à partir de la date actuel. -->

<div id="today-workout" class="form" >
  <h2> Next Workouts </h2>

<?php

$workouts_of_theday=getListExercices($idUser);


if (empty($workouts_of_theday)){
  echo "<h2>No exercice has been found, please contact your coach </h2><br>";
}

else{
  foreach ($workouts_of_theday as $workout){
    $title_woork = $workout['title'];
    $duration_woork = $workout['duration'];

    echo "<li><label class='titre'> $title_woork </label> DURATION: $duration_woork</li><br>";
  }
}
?>

</div>
  
<center>
<!-- Pour afficher le nom de coach de l'utilisateur connecté on a utilisé la fonction getCoach
qu'on a crée dans le fichier user_fucntions.php si l'utilisateur n'a pas encore de coach 
la page va afficher une place pour select pour choisir un user et envoyer -->

<div id="coach-user" class="form" >

  <?php

  if (empty(getCoach($idUser))){

    $listCoachs=getListCoach();
    
    echo "<h2 class='titre'>You don't have any coach yet.</h2><br>";
    echo "<label>You can add coach by selecting him and click Send</label><br>";

    echo '<br><form action="" method="post"><select name="invitation" class="connection-text-input" id="select-field"><option hidden>Choose here</option>';

    foreach( $listCoachs as $coach){
      $name_coach=$coach['login'];
      echo "<option >$name_coach</option>";
    }

    echo "</select><br><br>";

    
    echo "<input type='submit' class='form-button red-background' style='background:red;color:white;' name='Send' value='Send'></form>";  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


      if (isset($_POST['Send'])) {
        $nom_coach = $_POST['invitation'];
        // echo "<script>console.log(\"$nom_coach\");</script>";
        $idCoach=findCoachByName(strval($nom_coach))[0]['id'];
        // echo "<script>console.log($idCoach);</script>";
        if (empty($idCoach)){
          echo "Please retry later";
        }
        else{
          SendInvitation($idUser,$idCoach);
          echo "Invitation sent successfully";

        }
        
      }
    }  
  }
   
  
  // if(isset($_POST['invitation'])){
  //   $idCoach=$_POST['invitation'];
  //   echo("<script>alert($idCoach);</script>");
  //   // SendInvitation($idUser,$idCoach);

  else {
  $coach=getCoach($idUser)[0]['login'];
  echo "The pseudo of your coach is: <label class='titre'> $coach </label>";
  } 

  ?>

</div>
</center>
</div>
</script>
</body>
</html>

</div>
