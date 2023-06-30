<!-- Auteur : Oussama Mounajjim -->

<?php
include_once("libs/user_functions.php");

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
  header("Location:../index.php?view=user_workout");
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
    .titres {
      font-weight: bold;
      color: red;
    }
    #select-field{
      padding: 10px;
      border-radius: 3px;
    }
    #exercice-page{
      display: none;
    }
    #workout-user{
      display: block;
    }

  </style>

<!------------------------------------------------------------->



<body>
<center>
<div id="workout-user"  class="form">

<h1 id="title-page-workout"> WORKOUT PAGE</h1>

<div id="list-workout-user" >
  <?php
  $listExercices=getListExercices($idUser);
  foreach ($listExercices as $exercice)
  {
    $title_exercice = $exercice['title'];
    $duration = $exercice['duration'];
    echo "<h2 class='titres' >$title_exercice</h2><br>"; // Affiche le titre de l'exercice dans une balise h2 avec la classe "titres".
    echo "<label>$duration </label><br>"; // Affiche la durée de l'exercice dans une balise label.
  }
  if (empty($listExercices))
  {
    echo "<h2>No exercices found</h2><br>"; // Affiche un message si aucun exercice n'est trouvé.
  }
  ?>
  <br><br>
  <input type="button" id="button-start" class="form-button" style='background:red;color:white;' value="Start" onclick="to_exercice()">
</div>

</div>
<div id="exercice-page"  class="form">

<?php
$i=1;
$title_exercice="NO EXERCICE IS FOUND";
$duration="00:00:00";
$listexercices = getListExercices($idUser);
if (empty(getListExercices($idUser))){
  echo "<h2>No workout is selected</h2>"; // Affiche un message si aucun workout n'est sélectionné.
}
if(!empty(getListExercices($idUser))){
  
  $title_exercice= $listexercices[$i]['title'];
  $duration=$listexercices[$i]['duration'];
  
}
?>

  <div id="workout-title-user">
<?php
echo "<h1 id='title-exercice' class='titres'>$title_exercice</h1>"; // Affiche le titre de l'exercice dans une balise h1 avec la classe "titres".
?>
  </div>
  <div id="workout-image">
    <!-- Affiche la durée de l'exercice dans une balise h2 avec l'ID "title-exercice2". -->
<?php echo "<h2 id='title-exercice2'>You have $duration to do this exercice.</h2>" ?> 
</div>
<!--  Affiche un chronomètre initialisé à 00:00:00 dans une balise h1 avec l'ID "timer". -->
  <h1 id="timer" >00:00:00</h1> 
<input type="submit" class="form-button" style='background:red;color:white;' name="start" id="start-workout-button" value="Start"> 
<input type="submit" class="form-button" name="stop" id="stop-workout-button" value="Pause">
<input type="submit" class="form-button" name="next" id="next-workout-button" value="Next">
<input type="submit"class="form-button" name="cancel" id="cancel-workout-button" value="Cancel" onclick="to_workout()"> 
</div>
<script src="https://c
ode.jquery.com/jquery-3.7.0.js"></script>
<script>


  var dashboard_page=document.getElementById("dashboard-user");;
  var workout_page= document.getElementById("workout-user");
  var workout_user=document.getElementById("exercice-page");

  // La fonction to exercice pour aller vers la page des workout en utilisant les styles

  function to_workout() {
    workout_user.style.display="none";
    workout_page.style.display = "block";

  }
  // La fonction to exercice pour aller vers la page des exercices en utilisant les styles
  function to_exercice(){
    workout_page.style.display="none";
    workout_user.style.display="block";
  }
  var timerDisplay = document.getElementById("timer");
  var intervalId;
  var seconds = 0;




// Ici on initialise les differents fonctions pour les buttons de timer
    $( "#start-workout-button" ).on( "click", function() {
       
        clearInterval(intervalId);
        intervalId = setInterval(updateTimer, 1000);
    } );

    $( "#stop-workout-button" ).on( "click", function() {
      clearInterval(intervalId);
    } );

    $( "#next-workout-button" ).on( "click", function() {
      seconds = 0;
      updateTimer();
    } );



// la fonction updatetimer pour configurer les differents ordre de temps (minutes, heures, secondes)
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
