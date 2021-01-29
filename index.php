<?php
/*
Page de connexion: index.php
*/
session_start(); // cette fonction propre à PHP servira à maintenir la $_SESSION
//Connexion à la base de données
$db = mysqli_connect('localhost', 'root', '', 'bibiotheque');

if(isset($_POST['ok'])) { // si le bouton "Connexion" est appuyé
    // on vérifie que les champs "login" et "password" ne sont pas vides
if(empty($_POST['login']) OR empty($_POST['password'])) {

   $erreur="Tous les champs doivent etre complétés!";

}else {
            // les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
            $login = htmlspecialchars($_POST['login']); // le htmlentities() passera les guillemets en entités HTML, ce qui empêchera les injections SQL
            $password =($_POST['password']);
				// fait maintenant la requête dans la base de données pour rechercher si ces données existe et correspondent:
			$selection = "SELECT * FROM utilisateurs WHERE login='$login' AND password='$password'";
			$results = mysqli_query($db, $selection);
                if(mysqli_num_rows($results) == 0) {
                   $erreur="Login ou mot de pass incorrect!";
                } else {
                	// on ouvre la session avec $_SESSION:
                    $_SESSION['login'] = $login; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le login
                    
                    
                	if ($login=='admin' && $password=='admin') {//on vérifie l'utilisateur
									header("location:admin.php");//cela veut dire que c'est l'administrateur qui a la session
								}else{
									header("location:accueil.php");//on a le bibliothècaire qui se connecte
								}                 
                }         
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Connexion</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bibliothéque en ligne">
    <meta name="author" content="Abdoulaye SALL">
    <!-- Bootstrap CSS-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
</head>
<body>
<nav class="bg-info">
<h1 align="center"><i class="fas fa-book"></i> Bibliothéque 2.0</h1>
</nav>
<div class="container" align="center">
	<div class="row" id="connexion">
		<div class="col-lg-12" id="header_connexion">
			<h2 class="section-heading text-uppercase message" align="center">
				<i class="fas fa-3x fa-sign-in-alt"></i><br>
			</h2>
		</div>
		<div class="col-lg-12 bg-dark" id="content_connexion">
			<form action="index.php" method="POST">
				<table align="center">
					<tr>
						<td>
							<input  class="form-control input" type="text" name="login" placeholder="Login" 
									value="<?php if(isset($login)) {echo $login;}  ?>">
						</td>
					</tr>					
					<tr>
						<td>
							<input class="form-control input" type="password" name="password" placeholder="Mot de pass">
						</td>
					</tr>
					<tr align="center">
						<td>
							<input class="btn btn-info" type="submit" value="Se connecter" name="ok">
						</td>
					</tr>						
				</table>			
			</form><br>
			<h3 align="center">		
				<?php if (isset($erreur)) { echo '<div class="alert alert-danger" role="alert">'.$erreur.'</div>';} ?>					
			</h3>
		</div>
	</div>
</div>
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