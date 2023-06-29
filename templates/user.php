<?php
// $idUser=$_SESSION['user'];
$idUser=7;
$username="roben";
include_once("../libs/user_functions.php")

?>
<!DOCTYPE html>
<html>
  <head>
    
  </head>
  <style>
    .form{
      background-color: black;  
      opacity: 0.8;
      color: wheat;
      width: 400px;
      padding: 100px;
      text-align: center;
      border-radius: 10px;
      margin: 5px;
    }
    .page{
      background-color: antiquewhite;
      border-radius: 19px;
    }
    #button-start{
      background-color: green;
      width: auto;
      padding: 2px;
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
  </style>


<body>

  <input type="button" id="to_dashboard" value="dashboard" onclick="to_dashboard()">
  <input type="button" id="to_workout" value="workout" onclick="to_workout()">

<div id="dashboard-user" class="page">
  <center><h1 id="title-page-user" ><?php echo "Welcome $username "; ?></h1>
  <div id="division">
  <div>
  <div id="last-week-activity"  class="form"  >
<?php 
  $lastactivity = getLastActivity($idUser);
  foreach ($lastactivity as $activity) {
    $title = $activity['title'];
    $description = $activity['description'];
    $image = $activity['file'];
    $nbrep = $activity['nbRep'];
    echo "<h2>$title</h2><br>";
    echo "<label>$description</label><br>";
    echo "<label>$image</label><br>";
    echo "<label>$nbrep</label><br>";
}
// echo getLastActivity(7)[]
?>
</div>
  <div id="coach-user" class="form" >
  <?php
  $coach=getCoach($idUser)[0]['login'];
  echo $coach;
  ?>
  </div></div>
  <div id="today-workout" class="form" >
  <?php
  $workouts_of_theday=getListExercices($idUser);
  
  ?>
</div></div>
</div>
<center>
<div id="workout-user"  class="page">
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
    echo "<h2>No exercices founded</h2><br>";
  }
  ?>
</div>
</div>
<div id="exercice-page"  class="form">
  <div id="workout-title-user">
TITRE EXERCICE
  </div>
  <div id="workout-image">
  IMAGE
  </div>
  <div id="timer" >00:00:00</div>
<button type="button" id="start-workout-button" onclick="startTimer()">Start</button>
<input type="button" id="stop-workout-button" value="Stop" onclick="stopTimer()">
<input type="button" id="skip-workout-button" value="Skip" onclick="skipTimer()">
<input type="button" id="next-workout-button" value="Next" onclick="nextTimer()">
</div>
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

    function startTimer() {
      clearInterval(intervalId);
      intervalId = setInterval(updateTimer, 1000);
    }

    function stopTimer() {
      clearInterval(intervalId);
    }

    function skipTimer() {
      seconds = 0;
      updateTimer();
    }

    function nextTimer() {
      seconds = 0;
      updateTimer();
    }

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
