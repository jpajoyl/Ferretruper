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

	<title>Clientes | Ferretruper</title>
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
								<h1 class="main-title float-left">Clientes</h1>
								<ol class="breadcrumb float-right">
									<li class="breadcrumb-item">Pages</li>
									<li class="breadcrumb-item active">clientes</li>
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
											<h3><i class="fa fa-users"></i> Clientes disponibles</h3>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
											<a role="button" href="#" id="añadir-cliente" class="btn btn-success float-right" data-target="#añadirCliente" data-toggle="modal">Añadir Cliente<span class="btn-label btn-label-right"><i class="fa fa-user-circle"></i></span></a>
											<?php include 'includes/modalAddCliente.php';?>
										</div>
									</div>
								</div>							
								<div class="card-body">
									<table id="table-clientes" class="table table-bordered table-striped table-responsive-xl table-hover display">
										<thead class="cf">
											<tr>
												<th></th>
												<th>Identificación</th>
												<th>D. VERIF</th>
												<th>Nombre</th>
												<th>Email</th>
												<th>Direccion</th>
												<th>Ciudad</th>
												<th>Telefono</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="body-table-clientes">

										</tbody>
									</table>
								</div>
								<!-- Modal -->
								<div class="modal fade custom-modal" id="modal-editar-cliente" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="titleEditarCliente">Editar Cliente: <span id="id-cliente"></span><span id="digitoDeVerificacion"></span></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form autocomplete="off" action="#" id="form-editarCliente">
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Identificación <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-id-editar" placeholder="Identificación" autocomplete="off" required disabled>
														</div>
														<div class="form-group col-md-6">
															<label>Digito de verificación (Opcional)</label>
															<input type="number" class="form-control" id="input-digito-de-verificacion-editar" placeholder="Dig. de verificación" autocomplete="off">
														</div>
													</div>
													<div class="form-group">
														<label>Nombre<span class="text-danger">*</span></label>
														<input type="text" class="form-control" id="input-nombre-editar" placeholder="Nombre" required autocomplete="off">
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
														<input type="email" class="form-control" id="input-email-editar" placeholder="Email" autocomplete="off">
													</div>
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Telefono <span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-telefono-editar" placeholder="Telefono" required>
														</div>
														<div class="form-group col-md-6">
															<label>Celular</label>
															<input type="text" class="form-control" id="input-celular-editar" placeholder="Celular">
														</div>
													</div>
													<div class="form-group">
														<label>Clasificacion <span class="text-danger">*</span></label>
														<select class="custom-select" id="input-clasificacion-editar" required>
															<option value="">Selecciona la clasificacion</option>
															<option value="1.-GRANDE CONTRIB">1.-GRANDE CONTRIB</option>
															<option value="2">Two</option>
															<option value="3.-REGIMEN COMUN ">3.-REGIMEN COMUN</option>
															<option value="4.-REGIMEN SIMPLI">4.-REGIMEN SIMPLI</option>
														</select>
													</div>			
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-editarCliente">Cancelar</button>
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
	<script src="../assets/js/pagesJS/cliente.js"></script>
	<!-- END Java Script for this page -->

</body>
</html>