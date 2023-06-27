<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();

		echo "Action = '$action' <br />";

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			// Connexion //////////////////////////////////////////////////


			case 'Connexion':
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					verifUser($login,$passe); 	
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'SIGN UP':
				$login = valider("login");
				$passe = valider("passe");
				$userType = valider("userType");//normalement il y a toujours une valeur car la radio "utilisateur" est checked
				$confirm_passe = valider("confirm_passe");
				if(!$login) {
					//pas de login renseigné
					header("Location: index.php?view=signup&error=err_noLogin");
					die();
				}
				if(!$passe) {
					//pas de mot de passe renseigné
					header("Location: index.php?view=signup&error=err_noPassword");
					die();
				}
				//tous les champs du formulaire signup ont été correctement remplis
				if($passe == $confirm_passe) {
					//verification que le login n'est pas déjà utilisé par un autre utilisateur
					if(!verifLoginBdd($login)) {
						$isCoach = $userType == "coach" ? 1 : 0;
						//on insère le nouvel utilisateur dans la bdd
						ajouterUser($login,$passe,$isCoach);
						//on met à jour les variables de session
						verifUser($login,$passe);
						//on le redirige vers sa page d'accueil (coach ou user)
						if($isCoach){
							header("Location: index.php?view=coach");
							die();
						} else {
							header("Location: index.php?view=user");
							die();
						}
					} else {
						header("Location: index.php?view=signup&error=err_loginUsed");
						die();
					}
				} else {
					header("Location: index.php?view=signup&error=err_badConfirm");
					die();
				}
			break;
			
			case 'Annuler': //annulation de la création de compte
				header("Location: index.php?view=home");
				die();
			break;

			case 'Logout':
				session_destroy();
			break;
		}


	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);
	//qs doit contenir le symbole '?'

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










