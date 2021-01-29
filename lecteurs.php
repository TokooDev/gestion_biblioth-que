<?php
//Connectons nous dabord à notre base de données!
$db = mysqli_connect('localhost', 'root', '', 'bibiotheque');
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers la page de connexion
  header('Location: index.php');
  exit();
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

    <title>Lecteurs</title>
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
                  echo ('<a class="breadcrumb-item active" style="color:white;" href="admin.php">Vue d\'ensemble</a>');
                }else{
                  echo ('<a class="breadcrumb-item active" style="color:white;" href="accueil.php">Vue d\'ensemble</a>');
                }  
              ?>
            </li>
            <li class="breadcrumb-item active">Liste des lecteurs</li>
          </ol>
	<div class="row">
		<div class="col-xl-12 col-sm-6 mb-3">
			<div class="col-lg-12 header"><h1 class="section-heading text-uppercase" align="center"><i class="fas fa-users"></i> Nos lecteurs abonnés</h1>
			</div>
			<div class="col-xl-12 col-sm-6 mb-3 content">
			<?php 
				$lecteursParPage=5; //Nous allons afficher 5 lecteurs par page.
 
//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=mysqli_query($db,'SELECT COUNT(*) AS total FROM lecteurs'); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=mysqli_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
 
//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$lecteursParPage);
 
if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}
 
$premiereEntree=($pageActuelle-1)*$lecteursParPage; // On calcul la première entrée à lire
 
// La requête sql pour récupérer les lecteurs de la page actuelle.
$retourLecteur=mysqli_query($db,'SELECT * FROM lecteurs ORDER BY id_lecteur LIMIT '.$premiereEntree.', '.$lecteursParPage.'');
if($retourLecteur){
					echo "<table class='table table-sm table-hover'>\n";
					echo "<thead>\n";
					echo "<tr>\n";
					echo "<th scope='col'>Identifiant</th>\n";
					echo "<th scope='col'>Prénom</th>\n";
					echo "<th scope='col'>Nom</th>\n";
					echo "<th scope='col'>Adresse</th>\n";
					echo "<th scope='col'>Numéro d'identification nationale</th>\n";
					echo "<tr>\n";
					echo "</thead>\n";
while($donnees_lecteurs=mysqli_fetch_assoc($retourLecteur)){
						echo "<tbody>\n";
						echo "<tr>\n";
						echo "<td>".$donnees_lecteurs["id_lecteur"]."</td>\n";
						echo "<td>".$donnees_lecteurs["prenom"]."</td>\n";
						echo "<td>".$donnees_lecteurs["nom"]."</td>\n";
						echo "<td>".$donnees_lecteurs["adresse"]."</td>\n";
						echo "<td>".$donnees_lecteurs["cni"]."</td>\n";
						echo "<tr>\n";
						echo "</tbody>\n"; 
			}
			echo "</table>\n";
		}
			?>    
			</div>	
		<div class="col-xl-12 col-sm-6 mb-3 pagination pagination-lg" align="center">
				<?php
			echo "<nav aria-label='Page navigation'>";
			echo "<ul class='pagination'>";
			echo "<li class='page-item'><a class='page-link badge badge-info' href='lecteurs.php'>Précedent</a></li>";
			for($i=1; $i<=$nombreDePages; $i++){
			     if($i==$pageActuelle){
			  		echo "<li class='page-item'><a class='page-link badge badge-info' href='lecteurs.php?page=$i''>$i</a></li>";
			     }else{
			          echo "<li class='page-item'> <a class='page-link badge badge-info' href='lecteurs.php?page=$i'>$i</a></li> ";
			     }
			}
			echo "<li class='page-item'><a class='page-link badge badge-info' href='lecteurs.php?page=$i+1'>Suivant</a></li>";
				?>
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
    <a class="scroll-to-top rounded bg-dark" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap JavaScript-->
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
