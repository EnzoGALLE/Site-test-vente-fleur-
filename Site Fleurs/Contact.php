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
  </head>
  <body>
    <?php 
      include 'fonctions.php';
      session_start(); //On démarre la session
      if (empty($_SESSION)) { //si il y a une connexion faite sans session creer l'utilisateur seras rediriger vers la page connexions
        redirect("connexions.php",0);// POST
      }
      navigationSmall(3); //affichage de la navigation pour petit écrant?>
      <div class="container-fluid">
        <div class="row content">
          <?php navigationLarge(3); //affichage de la navigation pour grand écrant?>
          <br>
          <div class="col-sm-10">
            <div class="well text-center">
              <h2>Contact</h2>
              <?php echo '<p>Vous êtes connécté en tant que '.$_SESSION ["login"].'</p>' //Message qui affiche le login de l'utilisateur;?>
            </div>
            <div class="jumbotron">
              <h4 style="text-align: center;">Nous retrouver sur : </h4><br/>
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