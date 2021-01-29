<?php
//Connectons nous dabord à notre base de données!
$db = mysqli_connect('localhost', 'root', '', 'bibiotheque');
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si nulle, on redirige vers la page de connexion
  header('Location: index.php');
  exit();
}
//Maintenant occupons nous de l'ajout des livres
if (isset($_POST['ajouter'])) {
    $titre=htmlspecialchars($_POST['titre']);
    $auteurs=htmlspecialchars($_POST['auteurs']);
    $maison_edition=htmlspecialchars($_POST['maison_edition']);
    $id_lib=($_POST['id_lib']);
    $nombre_pages=htmlspecialchars($_POST['nombre_pages']);
    $stock=htmlspecialchars($_POST['stock']);
    $prix=($_POST['prix']);
  if (!empty($_POST['titre']) 
    AND !empty($_POST['auteurs']) 
    AND !empty($_POST['maison_edition']) 
    AND !empty($_POST['id_lib'])
    AND !empty($_POST['nombre_pages'])
    AND !empty($_POST['stock'])
    AND !empty($_POST['prix'])
  ) {
      $selection = "SELECT * FROM livres WHERE titre='$titre'";
      $results = mysqli_query($db, $selection);
      if (mysqli_num_rows($results) == 0) {
      $requette="INSERT INTO livres (titre,auteurs,maison_edition,id_lib,nombre_pages,stock,prix) 
            VALUES('$titre','$auteurs','$maison_edition','$id_lib','$nombre_pages','$stock','$prix')";
      $Inscription = mysqli_query($db, $requette);
      $erreur_succes="Livre ajouté(e) avec succés!";

      }else {
        $erreur="Ce bouquin existe déja en stock!";
      }
  }else{
    $erreur="Tous les champs doivent etre complétés!";
  }
}
//Modification
  if(isset($_POST['modifier'])){
    if(!empty($_POST['id_user']) && !empty($_POST['titre']) && !empty($_POST['auteurs']) && !empty($_POST['login']) && !empty($_POST['password'])){
        $id_user=$_POST['id_user'];
        $titre=$_POST['titre'];
        $auteurs=$_POST['auteurs'];
        $login=$_POST['login'];
        $password=($_POST['password']);
        $requette="UPDATE utilisateurs SET titre='$titre', auteurs='$auteurs',login='$login',password='$password'         WHERE id_user=$id_user";
        $modifier = mysqli_query($db, $requette);
        $erreur_succes="Modification effectuée avec succés!";
      }else{
        $erreur="Tous les champs doivent etre complétés!";
      }
    }
    //Suppression
      if(isset($_POST['supprimer'])){
      if(!empty($_POST['id_user'])){
        $id_user=($_POST['id_user']);
        $requette="DELETE FROM  utilisateurs WHERE id_user=$id_user";
        $supprimer = mysqli_query($db, $requette);
        $erreur_succes="Suppression effectuée avec succés!";      
      }else{
        $erreur="Aucun livre séléctionné!";
      }
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bibliothéque en ligne">
    <meta name="author" content="Abdoulaye SALL">
    <title>Ajout livre</title>
    <!-- Bootstrap  CSS-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
  </head>
  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-info static-top">
       <?php 
      if ($_SESSION['login'] == "admin") {
          echo ('<a class="navbar-brand mr-1" href="admin.php">Bibliothéque 2.0</a>');
        }else{
          echo ('<a class="navbar-brand mr-1" href="accueil.php">Bibliothéque 2.0</a>');
        }  
      ?>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link js-scroll-trigger"><i class="fas fa-user"></i> <?php echo "Bonjour ".$_SESSION['login'];?></a></li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
            </li>       
          </ul>
        </div>
    </nav>
    <div id="wrapper">
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-plus"></i>
            <span>Nouvelle entrée</span>
          </a>
          <?php
          if ($_SESSION['login'] == "admin") {
            echo('<div class="dropdown-menu bg-info" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Bibliothéquaires:</h6>
            <a class="dropdown-item" href="ajout_bibliothequaire.php">Ajouter</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Lecteurs:</h6>
            <a class="dropdown-item" href="ajout_lecteur.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Librairies:</h6>
            <a class="dropdown-item" href="ajout_librairie.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Livres:</h6>
            <a class="dropdown-item" href="ajout_livre.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Préts:</h6>
            <a class="dropdown-item" href="ajout_emprunt.php">Ajouter</a>
          </div>');

          }else{
            echo ('<div class="dropdown-menu bg-info" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Lecteurs:</h6>
            <a class="dropdown-item" href="ajout_lecteur.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Librairies:</h6>
            <a class="dropdown-item" href="ajout_librairie.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Livres:</h6>
            <a class="dropdown-item" href="ajout_livre.php">Ajouter</a>
                        <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Préts:</h6>
            <a class="dropdown-item" href="ajout_emprunt.php">Ajouter</a>
          </div>');
          }
          ?>
        </li>
      </ul>
      <div id="content-wrapper">
        <div class="container-fluid">
          <ol class="breadcrumb bg-dark">
            <li class="breadcrumb-item">
              <?php 
              if ($_SESSION['login'] == "admin") {
                  echo ('<a class="breadcrumb-item active" style="color:white;" href="admin.php">Tableau de bord</a>');
                }else{
                  echo ('<a class="breadcrumb-item active" style="color:white;" href="accueil.php">Tableau de bord</a>');
                }  
              ?>
            </li>
            <li class="breadcrumb-item active">Ajout livre</li>
          </ol>
  <div class="row">
  <div class="col-xl-10 col-sm-6 mb-3">
    <div class="row ajout">
      <div align="center" class="col-lg-12 header"> 
        <h1 align="center" class="section-heading text-uppercase"><i class="fas fa-2x fa-book"></i></h1>
      </div>
      <div class="col-lg-12 content">
        <form action="ajout_livre.php" method="POST">
          <table align="center">
          <tr>
          <td>
          <input class="form-control input" type="text" name="id_livre" placeholder="Identifiant du livre *">
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="titre" placeholder="Titre *" 
          value="<?php if(isset($titre)) {echo $titre;}  ?>"  >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="auteurs" placeholder="Auteur *" 
          value="<?php if(isset($auteurs)) {echo $auteurs;}  ?>"  >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="maison_edition" placeholder="Maison d'édition *" value="<?php if(isset($maison_edition)) {echo $maison_edition;}  ?>">
          </td>
          </tr>
          <tr>
          <td>
            <input class="form-control input" type="text" name="id_lib" placeholder="Identifiant Librairie *" value="<?php if(isset($id_lib)) {echo $id_lib;}  ?>">
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="nombre_pages" placeholder="nombre de pages *" 
          value="<?php if(isset($nombre_pages)) {echo $nombre_pages;}  ?>" >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="stock" placeholder="Stock disponibe *" 
          value="<?php if(isset($stock)) {echo $stock;}  ?>" >
          </td>
          </tr>

          <tr>
          <td>
          <input class="form-control input" type="text" name="prix" placeholder="Prix du livre *" value="<?php if(isset($prix)) {echo $prix;}  ?>">
          </td>
          </tr>

          <tr>
          <td align="center">
          <button  class="btn btn-success btn-xl " type="submit" name="ajouter">Ajouter <i class="fas fa-plus-square"></i> </button>
          <button class="btn btn-warning btn-xl" type="submit" name="modifier">Modifier <i class="fas fa-exchange-alt"></i></button>
          <button class="btn btn-danger btn-xl" type="submit" name="supprimer">Supprimer <i class="fas fa-trash-alt"></i></button>
          </td>
          </tr> 
          </table>                
        </form><br>
      <h5 align="center">       
      <?php
      if (isset($erreur)) {echo '<div class="alert alert-danger" role="alert">'.$erreur.'</div>';
      }
      elseif (isset($erreur_succes)) {echo '<div class="alert alert-success" role="alert">'.$erreur_succes.'</div>';
      }
      ?>    
      </h5> 
      </div>
    </div>
  </div>
  </div> 
        </div>
        <footer class="sticky-footer bg-info">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright ©  Abdoulaye SALL L2-Info ESITEC(SUPDECO) 2017/2018</span>
            </div>
          </div>
        </footer>

      </div>
    </div>
    <a class="scroll-to-top rounded bg-dark" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap JavaScript-->
    <script src="jquery/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>->
    <script src="jquery-easing/jquery.easing.min.js"></script>
    <script src="chart.js/Chart.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap4.js"></script>
    <script src="js/sb-admin.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
  </body>
</html>
