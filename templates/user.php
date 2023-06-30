<!-- Auteur : Oussama Mounajjim -->
<!-- Petites révisions par Roman Tiedrez -->

<style src="css/style.css"></style>

<?php
include_once("libs/user_functions.php");
include_once("libs/maLibForms.php");

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=user");
	die("");
}

$idUser = valider("idUser","SESSION");

?>
<!DOCTYPE html>
<html>
  <head>
    
  </head>
  <style>
    
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
      font-weight: bold;
      font-size: 18px;
    }
    .page{
      border-radius: 19px;
    }

    #dashboard-user{
      display: block;
    }
    #workout-user{
      display: none;
    }
    #exercice-page{
      display: none;
    }
    #title-page-user {
      color: white; 
  
    }
    #today-workout {
      width: 400px;
      height: 200px;
      overflow: auto;
    }
    #today-workout:hover{
      cursor: pointer;
    }
    #today-workout:hover{
      background-color: white;
      color: black;
    }
    #last-week-activity {
      width: 400px;
      height: 200px;
      overflow: auto;
    }
    #coach-user {
      width: 400px;
      height: 200px;
      overflow: auto;
    }
    #requete-coach {
      width: 400px;
      height: 200px;
      overflow: auto;
    }
    #title-page-user{
      color : white;  
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
<?php 
if(isset($_POST ['start'])){
  $i=$i+1;
  $title_exercice= $listexercices[$i]['title'];
  $duration=$listexercices[$i]['duration'];
}
?>

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
  <div id="division">
  <div>
  <div id="last-week-activity"  class="form" >

  <?php 
  echo "<h1>Activity (7 days)</h1><br>";
  $lastactivity = getLastActivity($idUser);

  if (empty($lastactivity)){
    echo "<h2>No workout has been done yet</h2><br>";

}

  foreach ($lastactivity as $activity) {


    $title = $activity['title'];
    $description = $activity['description'];
    $image = $activity['fichier'];
    $nbrep = $activity['nbRep'];
    $date = $activity['date'];

    if(!empty($title)){
      echo "<h2><label class='titre'></label> $title</h2>";
    }

    if(!empty($date)){
      echo "<h2><label class='titre'></label> $date</h2><br>";
    }

    /* if(!empty($description)){
      echo "<label><label class='titre'>Workout's Description:</label> $description</label><br>";
    }

    if(!empty($image)){
      echo "<label><label class='titre'>Workout's Image:</label> $image</label><br><br>";
    } */

    if(!empty($nbrep)){
      echo "<label><label class='titre'>Your reps:</label> $nbrep</label><br>";
    }
    

  }

  echo "</div>";


// echo getLastActivity(7)[]
?>
</div>

<!-- Cette div est pour les workouts qui suit, on a developpé une focntion getListExercices() qui revient la duration
et le titre de chaque exercice à partir de la date actuel. -->

<div id="today-workout" class="form" >

<?php
      echo "<h1>Today's workout</h1><br>";

      $workouts_of_theday=getListExercices($idUser);

      if (empty($workouts_of_theday)){
        echo "<h2>No exercice has been found, please contact your coach </h2><br>";
      }
      
      else {
        foreach ($workouts_of_theday as $workout){
          $title_woork = $workout['title'];
          $duration_woork = $workout['duration'];
      
          echo "<li><label class='titre'> $title_woork </label> DURATION: $duration_woork</li><br>";
        }
      }
      ?>

</div>

<!-- Pour afficher le nom de coach de l'utilisateur connecté on a utilisé la fonction getCoach
qu'on a crée dans le fichier user_fucntions.php si l'utilisateur n'a pas encore de coach 
la page va afficher une place pour select pour choisir un user et envoyer -->

<div id="requete-coach" class="form">
  <?php 
    if(!getCoach($idUser)) {
     if(!hasSentRequest($idUser)){
      echo "<h1>Request a coach</h1><br>";
      echo '<form action=controleur.php method=post name=invitation>';
      
      mkSelect("idCoach",getListCoach(),"id","login");
      echo "</select><br><br>";
      echo "<input type=\"submit\" name=\"action\" value=\"Send\"></form>";
    } else if (hasSentRequest($idUser)) {
      echo "<h1>Request sent</h1><br>";
      echo "<h2>Waiting for coach's answer</h2><br>";
    }
  } else {
    echo "Your coach: ";
    echo "<h2>".getCoach($idUser)."</h2><br>";
  }

    ?>


</div></div>
</div>
<script>

  $("#today-workout").on("click", function() {
    var url = window.location.href;
    url = url.split("/");
    indice = url.length;
    indice -= 1;
    console.log(url[indice]);
    var chaine = "";
    for (var i = 0; i < indice; i++) {
      chaine += url[i] + "/";
    }
    console.log(chaine);
    window.open(chaine + "index.php?view=user_workout", "_self");
  });

  $.ur


</script>
</body>
</html>

</div>
