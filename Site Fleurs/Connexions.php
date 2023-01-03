<!DOCTYPE html>
<html lang="fr">
	<head>
	  <title>L'ile au fleurs</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	  <link rel="stylesheet" href="style.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	  <style> /*style de mise en forme de la page*/
	    header, body,html{
			width: 100%;
			height: 100%;
		}
		header{
			background-image: url("images/fd.jpg");
			background-size: cover;
			background-position: center center;
			background-repeat: no-repeat;
			color: black;
		}
		.armature{
			display: table;
			width: 100%;
			height: 100%;
		}
		.contenue{
			display: table-cell;
			text-align: center;
			vertical-align: middle;
			text-shadow: 3px 3px 5px black;
		}
	  </style>
	</head>
	<body>
		<?php	
			include 'fonctions.php';
			session_start(); //On démarre la session
			// Affichage du formulaire de connexion
			afficheFormulaireConnexion();
			// Test de la connexion
			if (empty($_SESSION) && !empty($_POST) && isset($_POST ["login"])  && isset($_POST ["pass"]) ) {
				$connexion=compteExiste($_POST ["login"],$_POST ["pass"]); //Vérifie si le compte est valide ou non
				if ($connexion) { // ouverture de session
					addLogEvent($_POST ["login"],"réussi"); //Ajoute dans les logs un connexion réussi
					$_SESSION["login"]=$_POST ["login"];							
				}
				else {
					addLogEvent($_POST ["login"],"échouer"); //Ajoute dans les logs une connexion échouer
					echo '<p>Echec de connexion de '.$_POST ["login"].'</p>';
				}				
				redirect("index.php",0); //Redirige sur la page index, si le compte n'est pas valide l'uitlisateur reviendra sur cette page directement		
			} // Fin test de connexion
		?>
	</body>
</html>