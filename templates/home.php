<!-- A déplacer plus tard dans une feuille de style et dans le head de header.php ? -->
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

	<style type="text/css">
		body {
			font-family: 'Bebas Neue';
			background-image: url("https://i.pinimg.com/originals/c6/25/90/c62590c1756680060e7c38011cd704b5.jpg");
		}

		#corps {
			background-color: rgba(0,0,0,.8);
			border-radius: 17px;
			padding-left: 200px;
			padding-right: 200px;
			padding-top: 40px;
			padding-bottom: 30px;
			max-width: 1000px;
			width: fit-content;
			margin-left: auto;
			margin-right: auto;
		}

		.red{
			color: red;
		}

		h1 {
			color: white;
			font-size: 100px;
		}

		#corps p {
			color: white;
			font-size: 50px;
		}

		.material-symbols-outlined {  
			font-size: 50px;
			font-variation-settings:
				'FILL' 0,
				'wght' 500,
				'GRAD' 0,
				'opsz' 48
		}
	</style>
</head>


<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=home");
	die("");
}

?>

<div id="corps">
	<h1><span class="red">READY</span> </br> TO LIFT ?</h1>
	<p>
		<span class="material-symbols-outlined" style="color: red;">
		done
		</span>
		Pour les <span class="red">sportifs</span>
	</p>
	<p>
		<span class="material-symbols-outlined" style="color: red;">
			done
		</span>
		Pour les <span class="red">coachs</span>
	</p>
</div>
