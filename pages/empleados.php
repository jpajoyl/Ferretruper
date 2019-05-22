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

	<title>Empleados | Ferretruper</title>
	<meta name="description" content="Free Bootstrap 4 Admin Theme | Pike Admin">
	<meta name="author" content="Pike Web Development - https://www.pikephp.com">

	<!-- Favicon -->
	<link rel="shortcut icon" href="../assets/images/favicon.ico">

	<!-- Switchery css -->
	<link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="../assets/css/sweetalert2.min.css">

	<!-- Bootstrap CSS -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- Font Awesome CSS -->
	<link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<!-- Custom CSS -->
	<link href="../assets/css/customCSS/dataTableCollapse.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />	

	<!-- BEGIN CSS for this page -->
	<link rel="stylesheet" type="text/css" href="../assets/css/dataTables.bootstrap4.min.css"/>
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
								<h1 class="main-title float-left">Empleados</h1>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item">Pages</li>
									<li class="breadcrumb-item active">empleados</li>
								</ol>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<!-- end row -->


					<div class="row">
						<div class="col-xl-12">		
							<div class="card">
								<div class="card-header">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10">
											<h3><i class="fa fa-users"></i> Empleados disponibles</h3>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
											<a role="button" href="#" id="añadir-empleado" class="btn btn-success float-right" data-target="#añadirEmpleado" data-toggle="modal">Añadir Empleado<span class="btn-label btn-label-right"><i class="fa fa-user-circle"></i></span></a>
											<?php include 'includes/modalAddEmpleado.php';?>
										</div>
									</div>
								</div>							
								<div class="card-body">
									<table id="table-empleados" class="table table-bordered table-striped table-responsive-xl table-hover display">
										<thead class="cf">
											<tr>
												<th>Identificación</th>
												<th>Nombre</th>
												<th>Email</th>
												<th>Direccion</th>
												<th>Ciudad</th>
												<th>Telefono</th>
												<th>Celular</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="body-table-empleados">

										</tbody>
									</table>
								</div>
								<!-- Modal -->
								<div class="modal fade custom-modal" id="modal-editar-empleado" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="titleEditarempleado">Editar Empleado: <span id="id-empleado"></span><span id="digitoDeVerificacion"></span></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form autocomplete="off" action="#" id="form-editarEmpleado">
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Identificación <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-id-editar" placeholder="Identificación" autocomplete="off" required disabled>
														</div>
														<div class="form-group col-md-6">
															<label>Nombre<span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-nombre-editar" placeholder="Nombre" required autocomplete="off">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-8">
															<label>Dirección <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-direccion-editar" placeholder="Dirección" required>
														</div>
														<div class="form-group col-md-4">
															<label>Ciudad <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-ciudad-editar" placeholder="Ciudad" required>
														</div>
													</div>
													<div class="form-group">
														<label>Correo electronico</label>
														<input type="email" class="form-control" id="input-email-editar" placeholder="Correo electronico" autocomplete="off">
													</div>
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Telefono <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-telefono-editar" placeholder="Telefono" pattern="[0-9]+" required>
														</div>
														<div class="form-group col-md-6">
															<label>Celular</label>
															<input type="text" class="form-control" id="input-celular-editar" placeholder="Celular" pattern="[0-9]+">
														</div>
													</div>
													<div class="form-row">
													<div class="form-group col-md-6">
															<label>Usuario</span></label>
															<input type="text" class="form-control" id="input-usuario-editar" placeholder="Usuario"  pattern="[A-Za-z0-9]+">
														</div>
														<div class="form-group col-md-6">
															<label>Contraseña</label>
															<input type="text" class="form-control" id="input-contrasena-editar" placeholder="Contraseña" pattern="[A-Za-z0-9]+">
														</div>
													</div>			
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-editarEmpleado">Cancelar</button>
													<button type="submit" class="btn btn-success">Editar</button>
												</form>
											</div>
										</div>
									</div>
								</div>														
							</div><!-- end card-->
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
	<script src="../assets/js/Chart.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.buttons.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/js/pagesJS/empleados.js"></script>
	<!-- END Java Script for this page -->

</body>
</html>