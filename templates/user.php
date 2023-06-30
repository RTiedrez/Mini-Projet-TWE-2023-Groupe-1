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

  foreach ($lastactivity as $activity) {


    $title = $activity['title'];
    $description = $activity['description'];
    $image = $activity['fichier'];
    $nbrep = $activity['nbRep'];


    if(!empty($title)){
      echo "<h2><label class='titre'></label> $title</h2><br>";
    }

    /* if(!empty($description)){
      echo "<label><label class='titre'>Workout's Desciption:</label> $description</label><br>";
    }

    if(!empty($image)){
      echo "<label><label class='titre'>Workout's Image:</label> $image</label><br><br>";
    } */

    if(!empty($nbrep)){
      echo "<label><label class='titre'>Your reps:</label> $nbrep</label><br>";
    }

  }

  echo "</div>";

  if (empty($lastactivity)){
    echo "<h2>No workout has been done yet</h2><br>";

}
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
<center>
<div id="workout-user"  class="form">
<h1 id="title-page-workout"> WORKOUT </h1>
<input type="button" id="button-start" value="Start" onclick="to_exercice()">

<div id="list-workout-user" >
<?php
  $listExercices=getListExercices($idUser);
  foreach ($listExercices as $exercice)
  {
    $title_exercice = $exercice['title'];
    $duration = $exercice['duration'];
    echo "<h2>$title_exercice</h2><br>";
    echo "<label>$duration </label><br>";
  }
  if (empty($listExercices))
  {
    echo "<h2>No exercises found</h2><br>";
  }
  ?>
</div>

</div>
<div id="exercice-page"  class="form">

<?php
$i=1;
$title_exercice="NO EXERCISE FOUND";
$duration="00:00:00";
$listexercices = getListExercices($idUser);
if (empty(getListExercices($idUser))){
  echo "<h2>No workout is selected</h2>";
}
if(!empty(getListExercices($idUser))){
  
  $title_exercice= $listexercices[$i]['title'];
  $duration=$listexercices[$i]['duration'];
  
}
?>

  <div id="workout-title-user">
<?php
echo "<label id='title-exercice'>$title_exercice</label>";
?>
  </div>
  <div id="workout-image">
<?php echo "You have $duration to do this exercice." ?>
</div>
  <div id="timer" >00:00:00</div>
<input type="submit" name="start" id="start-workout-button" value="Start">
<input type="submit" name="stop" id="stop-workout-button" value="Pause">
<input type="submit" name="skip" id="skip-workout-button" value="Skip">
<input type="submit" name="next" id="next-workout-button" value="Next">
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
  var dashboard_page=document.getElementById("dashboard-user");;
  var workout_page= document.getElementById("workout-user");
  var workout_user=document.getElementById("exercice-page");

  $("#today-workout").on("click", function() {
    to_workout();
  });

  function to_dashboard() {
    if (dashboard_page.style.display == 'none') {
      workout_user.style.display="none";
      workout_page.style.display = "none";
      dashboard_page.style.display = "block";
    }
  }

  function to_workout() {
    workout_user.style.display="none";
      dashboard_page.style.display = "none";
      workout_page.style.display = "block";

  }
  function to_exercice(){
    dashboard_page.style.display = "none";
    workout_page.style.display="none";
    workout_user.style.display="block";
  }
  var timerDisplay = document.getElementById("timer");
  var intervalId;
  var seconds = 0;

    $( "#start-workout-button" ).on( "click", function() {
        clearInterval(intervalId);
        intervalId = setInterval(updateTimer, 1000);
    } );

    $( "#stop-workout-button" ).on( "click", function() {
      clearInterval(intervalId);
    } );

    $( "#skip-workout-button" ).on( "click", function() {
      seconds = 0;
      updateTimer();
    } );

    $( "#next-workout-button" ).on( "click", function() {

      updateTimer();
    } );


    function updateTimer() {
      var hours = Math.floor(seconds / 3600);
      var minutes = Math.floor((seconds % 3600) / 60);
      var remainingSeconds = seconds % 60;
      hours = (hours < 10 ? "0" : "") + hours;
      minutes = (minutes < 10 ? "0" : "") + minutes;
      remainingSeconds = (remainingSeconds < 10 ? "0" : "") + remainingSeconds;
      var timeString = hours + ":" + minutes + ":" + remainingSeconds;
      timerDisplay.innerHTML = timeString;

      seconds++;
    }
</script>
</body>
</html>

</div>
