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

	<title>Abastecer | Feretruper</title>
	<meta name="description" content="Free Bootstrap 4 Admin Theme | Pike Admin">
	<meta name="author" content="Pike Web Development - https://www.pikephp.com">

	<!-- Favicon -->
	<link rel="shortcut icon" href="../assets/images/favicon.ico">

	<!-- Switchery css -->
	<link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
	<link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../assets/css/jquery-ui.css">
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- Font Awesome CSS -->
	<link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link href="../assets/css/customCSS/dataTableCollapse.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../assets/css/dataTables.bootstrap4.min.css"/>
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
								<h1 class="main-title float-left">Abastecer</h1>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item">pages</li>
									<li class="breadcrumb-item active">abastecer</li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<!-- end row -->

					<div class="row">
						<div class="col-xl-12">
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-hand-pointer-o"></i>Informacion de busqueda</h3>
								</div>
								<div class="card-body">
									<form autocomplete="off" action="#" id="form-abastecer">
										<div class="form-row">
											<div class="form-group col-md-6">
												<label>Numero factura<span class="text-danger">*</span></label>
												<input type="number" class="form-control" id="input-numero-factura" placeholder="Numero de factura" autocomplete="off" required>
											</div>
											<div class="form-group col-md-6">
												<label>Nombre o NIT del proveedor<span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="input-nombre-o-nit" placeholder="Nombre o nit del proveedor" autocomplete="off" required>
											</div>
										</div>
										<input type="hidden" id="id-proveedor">
									</form>
								</div>
								
							</div><!-- end card-->													
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">					
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-table"></i> Productos del proveedor <span class="nombre-proveedor"></span></h3>
								</div>

								<div class="card-body">
									<table id="table-productos-proveedor" class="table table-bordered table-striped table-responsive-xl table-hover display">
										<thead class="cf">
											<tr>
												<th></th>
												<th>No. producto</th>
												<th>Nombre</th>
												<th>Cod. Barras</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="body-table-productos-proveedor">

										</tbody>
									</table>
									<a role="button" href="#" id="añadir-producto" class="btn btn-success float-right mt mr" data-target="#añadirProducto" data-toggle="modal">Añadir producto nuevo<span class="btn-label btn-label-right"><i class="fa fa-plus-square"></i></span></a>
								</div>														
							</div><!-- end card-->					
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-table"></i> Productos a abastecer</h3>
								</div>

								<div class="card-body">

									<table id="table-productos-compra" class="table table-responsive-xl table-striped">
										<thead>
											<tr>
												<th scope="col">No. producto</th>
												<th scope="col">Nombre</th>
												<th scope="col">Uds</th>
												<th scope="col">PU</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>

								</div>							
							</div><!-- end card-->					

						</div>
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
<script src="../assets/js/jquery-ui.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>
<script src="../assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="../assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dataTables.buttons.min.js"></script>
<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/js/addCliente.js"></script>
<script src="../assets/js/pagesJS/abastecer.js"></script>

<!-- END Java Script for this page -->

</body>
</html>

