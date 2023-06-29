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


			case 'SIGN IN':
				$login = valider("login");
				$passe = valider("passe");

				// On verifie la presence des champs login et passe
				if ($login = valider("login")) {
					if ($passe = valider("passe"))
					{
						// On verifie l'utilisateur, et on crée des variables de session si tout est OK
						// Cf. maLibSecurisation
						if(verifUser($login,$passe)){
							if($_SESSION["isCoach"]) 
								$qs="?view=coach_dashboard";
							else
								$qs="?view=user";						
						} else {
							$qs="?view=signin&error=err_loginOrPassword";
						}	
					} else {
						$qs="?view=signin&error=err_noPassword";
					}
				} else {
					$qs="?view=signin&error=err_noLogin";
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'SIGN UP':
				$login = valider("login");
				$passe = valider("passe");
				$userType = valider("userType");//normalement il y a toujours une valeur car la radio "utilisateur" est checked
				$confirm_passe = valider("confirm_passe");
				//pas de login renseigné
				if(!$login) $qs="?view=signup&error=err_noLogin";
				//pas de mot de passe renseigné
				else if(!$passe) $qs="?view=signup&error=err_noPassword";
				else if(strlen($login) > 16) $qs="?view=signup&error=err_loginLength";
				//tous les champs du formulaire signup ont été correctement remplis
				else if($passe == $confirm_passe) {
					//verification que le login n'est pas déjà utilisé par un autre utilisateur
					if(strlen($passe) <= 32) { //on vérifie qu'on ne dépasse pas les tailles définie dans la base de données
						if(!verifLoginBdd($login)) {
							$isCoach = $userType == "coach" ? 1 : 0;
							//on insère le nouvel utilisateur dans la bdd
							ajouterUser($login,$passe,$isCoach);
							//on met à jour les variables de session
							verifUser($login,$passe);
							//on le redirige vers sa page d'accueil (coach ou user)
							if($isCoach) $qs="?view=coach";
							else 		 $qs="?view=user";
						} else {
							$qs="?view=signup&error=err_loginUsed";
						}
					} else {
						$qs="?view=signup&error=err_passwordLength";
					}
				} else {
					$qs="?view=signup&error=err_badConfirm";
				}
			break;

			case 'Send':
				if($idCoach = valider("idCoach")) {
					$idUser = $_SESSION["idUser"];
					//on envoie une invitation au coach
					SendInvitation($idUser,$idCoach);
				}
				$qs="?view=user";
				break;

			case 'Annuler': // annulation de la création de compte
				$qs="?view=home";
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










