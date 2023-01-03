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
      navigationSmall(2); //affichage de la navigation pour petit écrant?>
      <div class="container-fluid">
        <div class="row content">
          <?php navigationLarge(2); //affichage de la navigation pour grand écrant ?>
          <br>  
          <div class="col-sm-10">
            <div class="well text-center">
              <h2>Nos produits</h2>
              <?php echo '<p>Vous êtes connécté en tant que '.$_SESSION ["login"].'</p>' //Message qui affiche le login de l'utilisateur;?>
            </div>
            <div class="jumbotron">
              <h4 style="text-align: center;">L'ensemble de nos produits :</h4><br/>
              <?php afficheTableau(listeFleur()); //affiche le tableau complet de la BDD?>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="jumbotron" style="text-align: center;">
                  <?php 
                    if(!empty($_POST["fleur"])){
                      echo "<h4>Recherche de fleur par type : (".$_POST["fleur"].")</h4>"; //Titre du tableau avec le type chosis 
                    }
                    else {
                      echo "<h4>Recherche de fleur par type :</h4>";
                    }
                    afficheFormulaireFleurParType() ;// affiche un formulaire avec tous les types de fleurs
                    if(!empty($_POST) && isset($_POST["fleur"])){ //si une valeur est entrer on affiche le tableau correspondant
                      afficheTableau(listeFleurParType($_POST["fleur"])); // affiche un tableau avec tous un type de fleur en particulier
                    }
                  ?>
                </div>
              </div>
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