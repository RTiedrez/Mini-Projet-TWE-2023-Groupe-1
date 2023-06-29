<!-- Auteur : Oussama Mounajjim -->
<style src="css/style.css"></style>

<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=workout");
	die("");
}
?>

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
    echo "<h2>No exercices found</h2><br>";
  }
  ?>
</div>
</div>
<div id="exercice-page"  class="form">

<?php
$i=1;
$title_exercice="NO EXERCICE FOUND";
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
<input type="submit" name="stop" id="stop-workout-button" value="Stop">
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