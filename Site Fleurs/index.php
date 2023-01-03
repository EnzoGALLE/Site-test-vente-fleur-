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
	    .connexions {
			float:right;
			padding-right: 3em;
		}
		.backco {
			background-color: grey;
		}
	  </style>
	</head>
	<body>
		<?php	
			include 'fonctions.php';
			session_start(); //On démarre la session
			if (empty($_SESSION)) { //si il y a une connexion faite sans session creer l'utilisateur seras rediriger vers la page connexions
				redirect("connexions.php",0);
			}
			navigationSmall(1); //affichage de la navigation pour petit écrant?>
			<div class="container-fluid">
			  <div class="row content">
			    <?php navigationLarge(1); //affichage de la navigation pour grand écrant?>
			    <br>
			    <div class="col-sm-10">
			      <div class="well text-center">
			        <h2>Accueil</h2>
			        <?php echo '<p>Vous êtes connécté en tant que '.$_SESSION ["login"].'</p>' //Message qui affiche le login de l'utilisateur;?>
			      </div>
			      <div class="col-sm-12 well text-center">
			        <h3>Bienvenue sur l'ile aux fleurs (Fleuriste)</h3>
			        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			      </div>
			    </div>
			  </div>
			</div>
		<?php footer(); 
			// Suppresion de la session 
			if (!empty($_GET) && isset($_GET["action"]) && $_GET["action"]=="logout" ){
				$_SESSION=array();
				session_destroy();
				redirect("connexions.php",0);
			}
		?>
	</body>
</html>