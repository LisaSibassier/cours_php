<?php
	//MODE DEBUG
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	//print_r($_POST);

	//CONNEXION BASE DE DONNEES MYSQL
	try 
	{
		$db = new PDO('mysql:host=localhost; dbname=blog_e_commerce; charset=utf8', 'root', 'root');
	}
	catch(Exception $e) 
	{
		die('Erreur : '.$e->getMessage());
	}
	
	$usertmp = "";
	$msg_error = "";

	//Si les champs ont été rempli, $_POST n'est donc pas vide
	if(!empty($_POST)) {
		//On injecte les variables de $_POST dans d'autres variables (Par sécurité)
		$mail = $_POST['mail'];
		$pass = $_POST['pass'];

		//On consulte la $db (base de donnée) avec une $req (requête sql)
		$req = $db->prepare('SELECT id FROM user WHERE mail= :mail');
		$req->bindParam(':mail', $mail);
		$req->execute();
		$checkmail = $req->fetch(); 

		//Si $mail existe dans la $db, $checkmail récupère une id et n'est donc pas "Empty"
		if (!empty($checkmail)) {

			//On consulte la $db avec une $req (requête sql)
			$req = $db->prepare('SELECT id FROM user WHERE mail= :mail AND password= :pass');
			$req->bindParam(':mail', $mail);
			$req->bindParam(':pass', $pass);
			$req->execute();
			$checkpass = $req->fetchAll(); 
			
			//Si le $mail et le $pass corresponde à l'utilisateur, $checkpass ne sera donc pas vide
			if (!empty($checkpass)) {
				header("location: index.php");
			//si le mot de passe ne corrspond pas :
			} else {
				$msg_error = "Mot de passe incorrect";
				$usertmp = $_POST['mail'];
			}
		//Si $mail n'est pas dans la base de donnée :
		} else {
			$msg_error = "Email utilisateur inconnu";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V3</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<span class="text-center p-t-90">
						<?= $msg_error ?>
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="mail" placeholder="Votre email" value="<?= $usertmp ?>">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Votre mot-de-passe">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>