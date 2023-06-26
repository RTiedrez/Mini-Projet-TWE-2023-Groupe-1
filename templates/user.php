<?php

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=user");
	die("");
}
include("templates/header.php");

?>

<div id="corps">

<h1>User page</h1>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div id="dashboard-user">
  <h1 id="title-page-user"></h1>
  <div id="last-week-activity" >

  </div>
  <div id="coach-user">

  </div>
  <div id="today-workout">

  </div>
</div>
<div id="workout-user">
<h1 id="title-page-workout"></h1>
<div id="button-start">

</div>
<div id="list-workout-user">

</div>
</div>
<div id="Exercice-page">
  <div id="workout-title-user">

  </div>
  <div id="workout-image">
  </div>
  <div id="timer">

  </div>
  <div id="start-workout-button">
  </div>
  <div id="stop-workout-button">
  </div>
  <div id="skip-workout-button">
  </div>
  <div id="next-workout-button">
  </div>
</div>
</body>
</html>

</div>
