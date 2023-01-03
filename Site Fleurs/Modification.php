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
      // Affichage du formulaire de connexion
      if (empty($_SESSION)) { //si il y a une connexion faite sans session creer l'utilisateur seras rediriger vers la page connexions
        redirect("connexions.php",0);// POST
      }
      else if(!isAdmin($_SESSION ["login"])){ //Si l'utilisateur n'est pas administrateur il seras rediriger sur la page index
        redirect("index.php",0);
      }
      navigationSmall(5) //affichage de la navigation pour petit écrant ?>
      <div class="container-fluid">
        <div class="row content">
          <?php navigationLarge(5) //affichage de la navigation pour grand écrant?>
          <br>
          <div class="col-sm-10">
            <div class="well text-center">
              <h2>Modification d'un produit</h2>
              <?php echo '<p>Vous êtes connécté en tant que '.$_SESSION ["login"].' en administrateur</p>' //Message qui affiche le login de l'utilisateur et sont status car si il est sur la page il ne peut que etre admin;?>
            </div>
            <div class="jumbotron col-sm-12">
              <div style="float:left;">
                <h3>Modifier un produit dans la base de donnée</h3><br/>
                <?php
                  choixdesignation(); // affiche un formulaire pour choisir quel fleur on veux modifier
                  if(!empty($_POST["choix"])){ //si un choix est entrer alors on affiche le formulaire de modification
                    $_SESSION['choix'] = $_POST["choix"];
                    afficheModification($_POST["choix"]);
                  }
                  else if(!empty($_POST) && isset($_POST["image"]) && isset($_POST["status"]) && isset($_POST["prix"])){
                    $res=modifiertable($_POST["nom"],$_POST["image"],$_POST["status"],$_POST["prix"]); //on modifie la table en fonction des choix de l'administrateur
                    redirect("modification.php",5);
                  }
                ?>
              </div>
              <div style="float:right;">               
              <?php 
                if(!empty($_SESSION["choix"])){ //on affiche l'image qui correspond à la fleur que l'on veut modifier
                  afficheimage($_SESSION['choix']);
                }
              ?>
              </div>
            </div>
            <?php
              if(!empty($_SESSION['choix'])){ //On affiche le résultat de la dernière modification 
                echo "<div class='jumbotron col-sm-12'><h3>Résultat de la modification</h3><br/>";
                afficheResultat($_SESSION['choix']);
                echo "</div>";
              }
            ?>
          </div>
        </div>
      </div>
    <?php
      footer();
      // Suppresion de la session 
      if (!empty($_GET) && isset($_GET["action"]) && $_GET["action"]=="logout" ){
        $_SESSION=array();
        session_destroy();
        redirect("connexions.php",0); 
      }
    ?>
  </body>
</html>