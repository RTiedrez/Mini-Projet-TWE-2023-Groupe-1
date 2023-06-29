<!-- Auteur : Oussama Mounajjim -->
<style src="css/style.css"></style>

<?php
include_once("libs/user_functions.php");

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
    body {
      overflow: hidden;
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
    #title-page-user{
      color: white; 
  
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

  <input type="button" id="to_dashboard" value="dashboard" onclick="to_dashboard()">
  <input type="button" id="to_workout" value="workout" onclick="to_workout()">

<div id="dashboard-user" class="page">
  <center><h1 id="title-page-user" ><?php echo "Welcome "; ?></h1>
  <div id="division">
  <div>
  <div id="last-week-activity"  class="form"  >
<?php 
  $lastactivity = getLastActivity($idUser);
 
  foreach ($lastactivity as $activity) {
    $title = $activity['title'];
    $description = $activity['description'];
    $image = $activity['fichier'];
    $nbrep = $activity['nbRep'];
    echo "<h2>$title</h2><br>";
    //echo "<label>$description</label><br>";
    //echo "<label>$image</label><br>";
    echo "<label>$nbrep</label><br> reps";
  }
  if (empty($lastactivity)){
    echo "<h2>No exercise has been done yet</h2><br>";
}
// echo getLastActivity(7)[]
?>
</div>
  <div id="coach-user" class="form" >
  <?php
  echo "Your coach: ";
  if (empty(getCoach($idUser))){
    echo "<h2>You don't have any coach yet.</h2><br>";
  } else {
  $coach=getCoach($idUser)[0]['login'];
  echo $coach;

  } 
  ?>
  </div></div>
  <div id="today-workout" class="form" >
  <?php
  $workouts_of_theday=getListExercices($idUser);
  if (empty($workouts_of_theday)){
    echo "<h2>No exercise has been found, please contact your coach </h2><br>";
  }
  else{
    foreach ($workouts_of_theday as $workout){
      $title_woork = $workout['title'];
      $duration_woork = $workout['duration'];
      echo "<li>$title_woork DURATION: $duration_woork</li><br>";
    }
  }
  ?>

</div>
<div id="requete-coach" class="form">
  <?php 
    if(!UserCoach($idUser)){
      echo '<form method="post"><select name="invitation">';
      $listCoachs=getListCoach();
      foreach( $listCoachs as $coach){
        $name_coach=$coach['login'];
        echo "<option >$name_coach</option>";
      }
      echo "</select><br><br>";
      echo "<input type='submit' name='invitation'></form>";   
      if(isset($_POST['invitation'])){
        $idCoach=$_POST['invitation'];
        echo("<script>alert($idCoach)</script>");
        // SendInvitation($idUser,$idCoach);
      } 
      
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
$title_exercice="NO EXERCISE IS FOUND";
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
