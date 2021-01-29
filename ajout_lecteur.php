<?php
//Connectons nous dabord à notre base de données!
$db = mysqli_connect('localhost', 'root', '', 'bibiotheque');
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si nulle, on redirige vers la page  de connexion
  header('Location: index.php');
  exit();
}
//Maintenant occupons nous de l'ajout des lecteurs
if (isset($_POST['ajouter'])) {
    $prenom=htmlspecialchars($_POST['prenom']);
    $nom=htmlspecialchars($_POST['nom']);
    $adresse=htmlspecialchars($_POST['adresse']);
    $cni=htmlspecialchars($_POST['cni']);
  if (!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['adresse']) AND !empty($_POST['cni'])) {
      $selection = "SELECT * FROM lecteurs WHERE cni='$cni'";
      $results = mysqli_query($db, $selection);
      if (mysqli_num_rows($results) == 0) {
      $requette="INSERT INTO lecteurs (prenom,nom,adresse,cni) 
            VALUES('$prenom','$nom','$adresse','$cni')";
      $Inscription = mysqli_query($db, $requette);
      $erreur_succes="Lecteur ajouté(e) avec succés!";

      }else {
        $erreur="Numéro d'identification déja utilisé!";
      }

  }else{
    $erreur="Tous les champs doivent etre complétés!";
  }
}
//Modification du lecteur
  if(isset($_POST['modifier'])){
    if(!empty($_POST['id_lecteur']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['adresse']) && !empty($_POST['cni'])){
        $id_lecteur=$_POST['id_lecteur'];
        $prenom=$_POST['prenom'];
        $nom=$_POST['nom'];
        $adresse=$_POST['adresse'];
        $cni=$_POST['cni'];
        $requette="UPDATE lecteurs SET prenom='$prenom', nom='$nom',adresse='$adresse',cni='$cni' WHERE id_lecteur=$id_lecteur";
        $modifier = mysqli_query($db, $requette);
        $erreur_succes="Modification effectuée avec succés!";
      }else{
        $erreur="Tous les champs doivent etre complétés!";
      }
    }
    //Suppression du lecteur
      if(isset($_POST['supprimer'])){
      if(!empty($_POST['id_lecteur'])){
        $id_lecteur=$_POST['id_lecteur'];
        $requette="DELETE FROM  lecteurs WHERE id_lecteur=$id_lecteur";
        $supprimer = mysqli_query($db, $requette);
        $erreur_succes="Suppression effectuée avec succés!";      
      }else{
        $erreur="Aucun(e) lecteur(e) séléctionné(e)!";
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
    <title>Ajout Lecteur</title>
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
      <!-- Menu gauche -->
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
            <li class="breadcrumb-item active">Ajout lecteur</li>
          </ol>
  <div class="row">
  <div class="col-xl-10 col-sm-6 mb-3">
    <div class="row ajout">
      <div align="center" class="col-lg-12 header"> 
        <h1 align="center" class="section-heading text-uppercase"><i class="fas fa-2x fa-book-reader"></i></h1>
      </div>
      <div class="col-lg-12 content">
        <form action="ajout_lecteur.php" method="POST">
          <table align="center">
          <tr>
          <td>
          <input class="form-control input" type="text" name="id_lecteur" placeholder="Identifiant *">
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="prenom" placeholder="Prénom *" 
          value="<?php if(isset($prenom)) {echo $prenom;}  ?>"  >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="nom" placeholder="Nom *" 
          value="<?php if(isset($nom)) {echo $nom;}  ?>"  >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="adresse" placeholder="Adresse *" 
          value="<?php if(isset($adresse)) {echo $adresse;}  ?>" >
          </td>
          </tr>
          <tr>
          <td>
          <input class="form-control input" type="text" name="cni" placeholder="CNI *" value="<?php if(isset($cni)) {echo $cni;}  ?>">
          </td>
          </tr> 
          <tr>
          <td align="center">
          <button  class="btn btn-success btn-xl " type="submit" name="ajouter">Ajouter <i class="fas fa-user-plus"></i> </button>
          <button class="btn btn-warning btn-xl" type="submit" name="modifier">Modifier <i class="fas fa-user-edit"></i></button>
          <button class="btn btn-danger btn-xl" type="submit" name="supprimer">Supprimer <i class="fas fa-user-minus"></i></button>    
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
              <span>Copyright ©  Abdoulaye SALL L2-Info ESITEC(SUPDECO) 2017/218</span>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <a class="scroll-to-top rounded bg-dark" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap  JavaScript-->
    <script src="jquery/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-easing/jquery.easing.min.js"></script>
    <script src="chart.js/Chart.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap4.js"></script>
    <script src="js/sb-admin.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
  </body>
</html>
