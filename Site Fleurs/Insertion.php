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
    <script src="form.js" type="text/javascript"></script>
    <style> /*style de mise en forme de la page*/
      table {
         border: 2px solid black;
         border-collapse: collapse;
         margin: auto;
      }
      th {
         background-color: lightgrey;
         font-size: 1.1em;
         padding: 10px;
         border: 2px solid black;
         text-align: center;
      }
      td {
         border: 1px solid black;
         text-align: center;
         padding: 10px;
      }
      tr{
      border: 1px solid black;
      }
    </style>
  </head>
  <body>
    <?php 
      include 'fonctions.php';
      session_start(); //On démarre la session

      if (empty($_SESSION)) { //si il y a une connexion faite sans session creer l'utilisateur seras rediriger vers la page connexions
        redirect("connexions.php",0);// POST
      }
      else if(!isAdmin($_SESSION ["login"])){ //Si l'utilisateur n'est pas administrateur il seras rediriger sur la page index
        redirect("index.php",0);
      }

      navigationSmall(4) //affichage de la navigation pour petit écrant ?>
      <div class="container-fluid">
        <div class="row content">
          <?php navigationLarge(4) //affichage de la navigation pour grand écrant?>
          <br>
          <div class="col-sm-10">
            <div class="well text-center">
              <h2>Insertion d'un produit</h2>
              <?php echo '<p>Vous êtes connécté en tant que '.$_SESSION ["login"].' en administrateur</p>' //Message qui affiche le login de l'utilisateur et sont status car si il est sur la page il ne peut que etre admin;?>
            </div>
            <div class="row jumbotron">
              <div class="col-sm-5">
              <h3>Insérer une nouvelle fleur dans la base de donnée</h3><br/>
              <?php
                afficheInsertion(); //affiche le formulaire d'insertion
                if(!empty($_POST) && isset($_POST["image"]) && isset($_POST["status"]) && isset($_POST["prix"]) && $_SESSION['valide']){
                  $res=ajoutfleur($_POST["reference"],$_POST["nom"],$_POST["prix"],$_POST["image"],$_POST["status"]); //ajoute une fleur dans la BDD en fonction des donner fournie par l'utilisateur (admin)
                  redirect("insertion.php",0); //refresh la page pour pouvoir inserer une nouvelle fleur
                }
              ?>
              </div>
              <div class="col-sm-7">
                <h4 style="text-align: center;">L'ensemble de nos produits :</h4><br/>
                <?php afficheTableau(listeFleur()); //affiche le tableau complet de la BDD?>
              </div>
            </div>
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