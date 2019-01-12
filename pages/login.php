<?php
	include_once '../assets/php/Conexion.php';
	include_once '../assets/php/Controllers/Response.php';
	include_once '../assets/php/Controllers/SesionEmpleado.php';
	include_once "../assets/php/Models/Usuario.php";
	include_once "../assets/php/Models/Empleado.php";
	include_once '../assets/php/Controllers/GetSession.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../assets/images/homeicon.ico"/>
	<link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/login/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/login/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/mainlogin.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('../assets/images/ferretruperbg.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" autocomplete="off">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-sign-in"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Iniciar sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Usuario">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Ingresar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="../assets/js/sweetalert2.min.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/daterangepicker/moment.min.js"></script>
	<script src="../assets/login/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../assets/js/login.js"></script>

</body>
</html>