<?php
//*******************************************************************************************
function ajoutfleur($ref,$designation,$prix,$image,$categorie){
$retour=0;
$madb = new PDO('sqlite:bdd/Fleurs.sqlite');   
// filtrer les paramètres 
$ref = $madb->quote($ref);
$designation = $madb->quote($designation);
$prix = $madb->quote($prix);
$image = $madb->quote($image);
$categorie = $madb->quote($categorie);

$sql = "INSERT INTO produit VALUES($ref,$designation,$prix,$image,$categorie)"; //insert une fleur dans la BDD en focntion des parametres de la fonction
$resultat = $madb->exec($sql);
if($resultat!=false) $retour=1;
return $retour;//retounre 1 ou 0 en fonction du résultat ex : 0 = echec de l'ajout
}

//*******************************************************************************************
function afficheInsertion(){
  // connexion BDD
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite');
  $sql = "SELECT pdt_designation,pdt_prix,pdt_image FROM produit ORDER BY pdt_ref";
  $resultat = $madb->query($sql);
  $fleurs = $resultat->fetchAll(PDO::FETCH_ASSOC);?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return verifForm(this)">
    <fieldset>
      <label for="Nom">Nom de la fleur :</label>
        <input type="text" name="nom" id="name" placeholder="Nom" required size="20" onblur="veriftext(this)"/><br />
        <label for="Localisation">Référence :</label>
        <input type="text" name="reference" id="name" placeholder="Référence" required size="30" onblur="veriftext(this)"/><br />
        <label for="Prix">Prix (en euro): </label>
        <input type="number" name="prix" placeholder="Prix" id="prix" size="5" required onblur="verifchiffre(this)"/><br />
        <label for="Localisation">Image :</label>
        <input type="text" name="image" id="name" placeholder="Localisation" required size="30" onblur="veriftext(this)"/><br />
        <label for="id_status">Type de fleur :</label> 
        <input type="radio" name="status" value="1"> Bulbes 
        <input type="radio" name="status" value="2" > PLante à massif
        <input type="radio" name="status" value="3"> Rosier<br/><br/>
        <form>
          <input type="text" name="captcha" placeholder="Entrer le code afficher"/>
          <img src="Images/image.php" onclick="this.src='Images/image.php?' + Math.random();" alt="captcha" style="cursor:pointer;">
          <?php 
            $cap=1;
            if(isset($_POST['captcha'])){
                if($_POST['captcha']==$_SESSION['code']){
                    echo "Code correct";
                    $_SESSION['valide']=true;
                  //on traite le formulaire
                } else {
                    echo "Code incorrect";
                    $_SESSION['valide']=false;
                  //averti qu'il y a une erreur
                }
            }
          ?>
        </form>
      <br/><br/><input type="submit" value="Envoyer"/>
    </fieldset>
  </form>
<?php
}

//*******************************************************************************************
function choixdesignation(){
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite');
  $sql = "SELECT pdt_designation FROM produit ORDER BY pdt_designation";
  $resultat = $madb->query($sql);
  $valeur = $resultat->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset> 
      <select id="choix" name="choix" size="1">
        <?php
          foreach($valeur as $valeurs){
            echo '<option Value="'.$valeurs['pdt_designation'].'">'.$valeurs['pdt_designation'].'</option>';//on affiche toutes les fleurs
          }
        ?>
      </select>
      <input type="submit" value="Modifier"/>
    </fieldset>
  </form>
<?php
echo "<br/>";
}

//*******************************************************************************************
function afficheModification($choix){
    // connexion BDD
    $madb = new PDO('sqlite:bdd/Fleurs.sqlite');
    $choix = $madb->quote($choix);
    $sql2 = "SELECT * FROM produit WHERE pdt_designation=$choix";
    $resultat2 = $madb->query($sql2);
    $info = $resultat2->fetch(PDO::FETCH_ASSOC);
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset> 
      <label for="Nom">Produit : </label>
      <input type="text" name="nom" id="nom" placeholder="Nom" required size="40" value="<?php echo $info['pdt_designation'] ?>" readonly /><br />
      <label for="Localisation">Image (Localisation): </label>
      <input type="text" name="image" id="image" size="20" value="<?php echo $info['pdt_image'] ?>" /><br />
      <label for="Prix">Prix (en euro): </label>
      <input type="text" name="prix" id="prix" size="2" value="<?php echo $info['pdt_prix'] ?>" /><br />
      <label for="id_status">Type de fleur :</label> 
      <?php
        // selectione le bon bonton radio en fonction du status
        if($info['pdt_categorie']=='1'){
          echo '<input type="radio" name="status" value="1" checked> Bulbes';
          echo '<input type="radio" name="status" value="2"> Plantes à massif';
          echo '<input type="radio" name="status" value="3"> Rosiers<br/>';
        }
        else if($info['pdt_categorie']=='2'){
          echo '<input type="radio" name="status" value="1" > Bulbes';
          echo '<input type="radio" name="status" value="2" checked> Plantes à massif';
          echo '<input type="radio" name="status" value="3"> Rosiers<br/>';
        }
        else if($info['pdt_categorie']=='3'){
          echo '<input type="radio" name="status" value="1"> Bulbes';
          echo '<input type="radio" name="status" value="2"> Plantes à massif';
          echo '<input type="radio" name="status" value="3" checked> Rosiers<br/>';
        }
      ?>
      <br/><input type="submit" value="Valider"/>
    </fieldset>
  </form>
  <br/>
<?php
}

function afficheResultat($choix){//même fonction que afficheModification mais sur ce formulaire réduit on ne peut rien modifier
    // connexion BDD
    $madb = new PDO('sqlite:bdd/Fleurs.sqlite');
    $choix = $madb->quote($choix);
    $sql2 = "SELECT * FROM produit WHERE pdt_designation=$choix";
    $resultat2 = $madb->query($sql2);
    $info = $resultat2->fetch(PDO::FETCH_ASSOC);
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset> 
      <label for="Nom">Produit : </label>
      <input type="text" required size="40" value="<?php echo $info['pdt_designation'] ?>" readonly /><br />
      <label for="Localisation">Image (Localisation): </label>
      <input type="text"size="20" value="<?php echo $info['pdt_image'] ?>" readonly/><br />
      <label for="Prix">Prix (en euro): </label>
      <input type="text" size="2" value="<?php echo $info['pdt_prix'] ?>" readonly/><br />
      <label for="id_status">Type de fleur :</label> 
      <?php
        // selectione le bon bonton radio en fonction du status
        if($info['pdt_categorie']=='1'){
          echo '<input type="radio" checked > Bulbes';
          echo '<input type="radio"> Plantes à massif';
          echo '<input type="radio"> Rosiers';
        }
        else if($info['pdt_categorie']=='2'){
          echo '<input type="radio"> Bulbes';
          echo '<input type="radio" checked> Plantes à massif';
          echo '<input type="radio"> Rosiers';
        }
        else if($info['pdt_categorie']=='3'){
          echo '<input type="radio"> Bulbes';
          echo '<input type="radio"> Plantes à massif';
          echo '<input type="radio" checked> Rosiers';
        }
      ?>
    </fieldset>
  </form>
<?php
}

function afficheimage($choix){
    // connexion BDD
    $madb = new PDO('sqlite:bdd/Fleurs.sqlite');
    $choix = $madb->quote($choix);
    $sql2 = "SELECT * FROM produit WHERE pdt_designation=$choix";
    $resultat2 = $madb->query($sql2);
    $info = $resultat2->fetch(PDO::FETCH_ASSOC);
    echo"<img src=".$info['pdt_image']." alt='Image du produit' style='img-responsive'>";//affiche une image avec une valeur stocker dans la BDD
}

//*******************************************************************************************
function modifiertable($pdt_designation,$pdt_image,$pdt_categorie,$pdt_prix){
  $retour=0;
  $madb = new PDO('sqlite:bdd/fleurs.sqlite');
  $pdt_designation = $madb->quote($pdt_designation);
  $pdt_image = $madb->quote($pdt_image);
  $pdt_categorie = $madb->quote($pdt_categorie);
  $pdt_prix = $madb->quote($pdt_prix);
  $sql = "UPDATE produit SET pdt_image=$pdt_image, pdt_categorie=$pdt_categorie, pdt_prix=$pdt_prix WHERE pdt_designation=$pdt_designation"; //permet de modifier une valeur dans la BDD
  $resultat=$madb->exec($sql);
  if($resultat!=false) $retour=1;
  return $retour;
}

//*******************************************************************************************
function compteExiste($login,$pass){
  $retour = false ;
  $madb = new PDO('sqlite:bdd/Comptes.sqlite'); 
  $login= $madb->quote($login);
  $pass = $madb->quote($pass);
  $requete = "SELECT LOGIN,PASS FROM utilisateurs WHERE LOGIN LIKE $login AND PASS LIKE $pass" ;
  //var_dump($requete);echo "<br/>";    
  $resultat = $madb->query($requete);
  $tableau_assoc = $resultat->fetchAll(PDO::FETCH_ASSOC);
  if (sizeof($tableau_assoc)!=0) $retour = true;  
  return $retour; //si l'execution de la requete est correct alors le compte existe et donc on renvoie true
} 

//*******************************************************************************************
function redirect($url,$tps){
    $temps = $tps * 1000;

    echo "<script type=\"text/javascript\">\n"
    . "<!--\n"
    . "\n"
    . "function redirect() {\n"
    . "window.location='" . $url . "'\n"
    . "}\n"
    . "setTimeout('redirect()','" . $temps ."');\n"
    . "\n"
    . "// -->\n"
    . "</script>\n";
} 

//*******************************************************************************************
function isAdmin($login){
  $retour = false ;
  $madb = new PDO('sqlite:bdd/Comptes.sqlite'); 
  $login= $madb->quote($login);
  $requete = "SELECT STATUT FROM utilisateurs WHERE LOGIN LIKE $login" ;
  $resultat = $madb->query($requete);
  if ($resultat) {
    $statut=$resultat->fetch(PDO::FETCH_ASSOC);
    if ($statut['STATUT']=="administrateur") $retour=true;
  }
  return $retour;  //si l'execution de la requete est correct alors le compte est un administrateur et donc on renvoie true
}

//*******************************************************************************************
function afficheFormulaireConnexion(){ ?>
<header>
  <div class="armature">
    <div class="contenue">
      <form class="backco" id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>  
          <span class="connexions"><label for="id_login">Login : </label> <input type="text" name="login" id="id_login" placeholder="Login" required size="20" />
          <label for="id_pass">Mot de passe : </label> <input type="password" name="pass" id="id_pass" required size="20" />
          <input type="submit" name="connect" value="Connexion" /></span>
        </fieldset>
      </form>
    </div>
  </div>
</header>
<?php } 

//*******************************************************************************************
function listeFleur()  {
  $retour = false ; 
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite'); 
  $requete = "SELECT pdt_ref,pdt_designation,pdt_prix,pdt_image,pdt_categorie FROM produit ORDER BY pdt_ref"; //prend toute les données de la BDD
  $resultat = $madb->query($requete);
  $fleurs = $resultat->fetchAll(PDO::FETCH_ASSOC); 
  if (sizeof($fleurs)!=0) $retour = $fleurs;    
  return $retour;
}

//*******************************************************************************************
function listeFleurParType($type){
  $retour = false ;
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite'); 
  $type =$madb->quote($type);
  $requete = "SELECT pdt_ref,pdt_designation,pdt_prix,pdt_image FROM produit p INNER JOIN categorie c WHERE p.pdt_categorie=c.cat_code AND c.cat_libelle =$type" ; //prend les données en fonction d'un type de fleur renseigner dans les paramètre de la fonction
  $resultat = $madb->query($requete);
  $fleurs = $resultat->fetchAll(PDO::FETCH_ASSOC);
  if (sizeof($fleurs)!=0) $retour = $fleurs;
  return $retour;
}

//*******************************************************************************************
function afficheFormulaireFleurParType(){
  echo "<br/>";
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite'); 
  $sql = "SELECT cat_libelle FROM  categorie";
  $resultat = $madb->query($sql);
  $fleurs = $resultat->fetchAll(PDO::FETCH_ASSOC); ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset> 
      <label for="id_fleur">Type de fleur :</label> 
      <select id="id_fleur" name="fleur" size="1">
        <?php
          foreach($fleurs as $fleur){
            echo '<option Value="'.$fleur['cat_libelle'].'">'.$fleur['cat_libelle'].'</option>';//Boucle qui affiche toute les "cat_libelle" qui existe dans la BDD
          } 
        ?>
      </select>
      <input type="submit" value="Lancer la recherche"/>
    </fieldset>
  </form><br/>
<?php
}

//*******************************************************************************************
function afficheTableau($tab){
  echo '<table>'; 
  echo '<tr>';// les entetes des colonnes
  foreach($tab[0] as $colonne=>$valeur){    echo "<th>$colonne</th>";   }
  echo "</tr>\n";
  // le corps de la table
  foreach($tab as $ligne){
    echo '<tr>';
    foreach($ligne as $cellule)   {   echo "<td>$cellule</td>";   }
    echo "</tr>\n";
    }
  echo '</table>';
}

//*******************************************************************************************
function afficheFormulaireChoixFleur($choix){
  $madb = new PDO('sqlite:bdd/Fleurs.sqlite'); 
  $sql = "SELECT pdt_designation FROM produit ORDER BY pdt_designation"; //on récupère les designation existante dans la BDD
  $resultat = $madb->query($sql);
  $fleur = $resultat->fetchAll(PDO::FETCH_ASSOC);     
  ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset> 
      <select id="id_mail" name="mail" size="1">
        <?php // on se sert de value directement 
          // boucle qui permet d'aficher touts les utilisateurs
          foreach($fleur as $fleurs){
            echo '<option Value="'.$fleurs['pdt_designation'].'">'.$fleurs['pdt_designation'].'</option>';//Boucle qui affiche toute les "pdt_designation" qui existe dans la BDD
          }
        ?>
      </select>
      <input type="submit" name="<?php echo $choix?>" value="<?php echo $choix?>"/>
    </fieldset>
  </form>
<?php
  echo "<br/>";
}

//*******************************************************************************************
function navigationSmall($page){?>
  <nav class="navbar navbar-inverse visible-xs">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <img class="img-responsive" src="Images/logo.png">
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
            <?php if($page==1){ ?>
            <li class="active"><a href="index.php">Acceuil</a></li>
          <?php } else { ?>
          <li><a href="index.php">Acceuil</a></li>
          <?php }
          if($page==2){ ?>
            <li class="active"><a href="Produit.php">Nos Produits</a></li>
          <?php } else { ?>
          <li><a href="Produit.php">Nos Produits</a></li>
          <?php }
          if($page==3){ ?>
            <li class="active"><a href="Contact.php">Contact</a></li>
          <?php } else { ?>
          <li><a href="Contact.php">Contact</a></li>
          <?php } 
          if (isAdmin($_SESSION ["login"])) { //affiche la page insertion et modification si on est administrateur
            if($page==4){ //permet de mettre en valeur la page ou l'on se trouve?>
              <li class="active"><a href="Insertion.php">Insertion d'un produit</a></li>
            <?php } else { ?>
            <li><a href="Insertion.php">Insertion d'un produit</a></li>
            <?php } if($page==5){ //permet de mettre en valeur la page ou l'on se trouve?>
              <li class="active"><a href="Modification.php">Modification d'un produit</a></li>
            <?php } else {?>
            <li><a href="Modification.php">Modification d'un produit</a></li>
          <?php } ?>
          <?php } ?>
          <li><a href="index.php?action=logout" title="Déconnexion">Se déconnecter</a></li>
        </ul>
      </div>
    </div>
  </nav>
<?php } 

//*******************************************************************************************
function navigationLarge($page){?>
    <div class="col-sm-2 sidenav hidden-xs navbar-inverse">
      <img class="img-responsive" src="Images/logo.png">
      <ul class="nav nav-pills nav-stacked">
        <?php if($page==1){ ?>
          <li class="active"><a href="index.php">Acceuil</a></li>
        <?php } else { ?>
        <li><a href="index.php">Acceuil</a></li>
        <?php }
        if($page==2){ ?>
          <li class="active"><a href="Produit.php">Nos Produits</a></li>
        <?php } else { ?>
        <li><a href="Produit.php">Nos Produits</a></li>
        <?php }
        if($page==3){ ?>
          <li class="active"><a href="Contact.php">Contact</a></li>
        <?php } else { ?>
        <li><a href="Contact.php">Contact</a></li>
        <?php } 
        if (isAdmin($_SESSION ["login"])) { //affiche la page insertion et modification si on est administrateur
          if($page==4){ //permet de mettre en valeur la page ou l'on se trouve?>
            <li class="active"><a href="Insertion.php">Insertion d'un produit</a></li>
          <?php } else { ?>
          <li><a href="Insertion.php">Insertion d'un produit</a></li>
          <?php } if($page==5){ //permet de mettre en valeur la page ou l'on se trouve?>
            <li class="active"><a href="Modification.php">Modification d'un produit</a></li>
          <?php } else {?>
          <li><a href="Modification.php">Modification d'un produit</a></li>
        <?php } ?>
      <?php } ?>
      <li><a href="index.php?action=logout" title="Déconnexion">Se déconnecter</a></li>
      </ul><br>
      <hr class="featurette-divider">
    </div>
<?php }

//*******************************************************************************************
function footer(){?>
<footer class="container-fluid text-center">
  <p>Copyright by Enzo GALLE et Hind FARIS</p>  
</footer>
<?php }

//*******************************************************************************************
function addLogEvent($login, $etat){
    $time = date("D, d M Y H:i:s");
    $time = "[".$time."] ";
    file_put_contents("log.log", $time." Connexion ".$etat." sur le compte ".$login." avec l'ip ".$_SERVER['REMOTE_ADDR']."\n", FILE_APPEND); //ajoute une ligne au fichier .log avec l'heure, la date, le login, l'ip, et l'etat de la connexion 'réussi' ou 'échouer'
}
?>