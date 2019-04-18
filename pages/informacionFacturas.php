<?php
include_once '../assets/php/Conexion.php';
include_once '../assets/php/Controllers/SesionEmpleado.php';
include_once "../assets/php/Models/Usuario.php";
include_once "../assets/php/Models/Empleado.php";
include_once '../assets/php/Controllers/GetSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Informacion facturas</title>
	<meta name="description" content="Free Bootstrap 4 Admin Theme | Pike Admin">
	<meta name="author" content="Pike Web Development - https://www.pikephp.com">

	<!-- Favicon -->
	<link rel="shortcut icon" href="../assets/images/favicon.ico">

	<!-- Switchery css -->
	<link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
	<link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

	<!-- Bootstrap CSS -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- Font Awesome CSS -->
	<link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<!-- Custom CSS -->
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />	

	<!-- BEGIN CSS for this page -->

	<!-- END CSS for this page -->

</head>

<body class="adminbody">

	<div id="main">

		<!-- top bar navigation -->
		<?php include("includes/header.php"); ?>
		<!-- End Navigation -->


		<!-- Left Sidebar -->
		<?php include("includes/sidebar.php"); ?>
		<!-- End Sidebar -->


		<div class="content-page">

			<!-- Start content -->
			<div class="content">

				<div class="container-fluid">

					
					<div class="row">
						<div class="col-xl-12">
							<div class="breadcrumb-holder">
								<h1 class="main-title float-left">Editar la informacion de las facturas</h1>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item">Pages</li>
									<li class="breadcrumb-item active">Facturas</li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<!-- end row -->
					<div class="row">

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-check-square-o"></i>Información factura POS</h3>
								</div>

								<div class="card-body">

									<form id="form-pos">
										<div class="form-group">
											<label>Número de inicio DIAN</label>
											<input type="number" class="form-control" id="numero-dian-pos" placeholder="Número de inicio DIAN" required>
										</div>
										<div class="form-group">
											<label>Información acerca de la resolución</label>
											<textarea type="text" class="form-control" id="r-descripcion-pos" placeholder="Información acerca de la resolución" required></textarea>
										</div>
										<div class="form-group">
											<label>Información opcional de la factura</label>
											<textarea type="text" class="form-control" id="i-descripcion-pos" placeholder="Información opcional de la factura"></textarea>
										</div>
										<button type="submit" class="btn btn-primary">Enviar</button>
									</form>

								</div>														
							</div><!-- end card-->					
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-check-square-o"></i>Información factura carta</h3>
								</div>
								
								<div class="card-body">
									
									<form id="form-carta">
										<div class="form-group">
											<label>Número de inicio DIAN</label>
											<input type="number" class="form-control" id="numero-dian-carta" placeholder="Número de inicio DIAN" required>
										</div>
										<div class="form-group">
											<label>Información acerca de la resolución</label>
											<textarea type="text" class="form-control" id="r-descripcion-carta" placeholder="Información acerca de la resolución" required></textarea>
										</div>
										<div class="form-group">
											<label>Información opcional de la factura</label>
											<textarea type="text" class="form-control" id="i-descripcion-carta" placeholder="Información opcional de la factura"></textarea>
										</div>
										<button type="submit" class="btn btn-primary">Enviar</button>
									</form>
									
								</div>														
							</div><!-- end card-->					
						</div>
					</div>
				</div>
				<!-- END container-fluid -->

			</div>
			<!-- END content -->

		</div>

		<div class="row">
			<div class="col-xl-12">									
				<!-- MODALS -->
				<?php include 'includes/modalAddCliente.php';?>
			</div>
		</div>



	</div>
	<!-- END container-fluid -->

</div>
<!-- END content -->

</div>
<!-- END content-page -->

<?php include("includes/footer.php"); ?>

</div>
<!-- END main -->

<script src="../assets/js/sweetalert2.min.js"></script>
<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/moment.min.js"></script>

<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>
<script src="../assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="../assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
<script src="../assets/js/addCliente.js"></script>
<script src="../assets/js/pagesJS/infoFacturas.js"></script>
<!-- END Java Script for this page -->

</body>
</html>