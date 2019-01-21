<?php
include_once '../assets/php/Conexion.php';
include_once '../assets/php/Controllers/SesionEmpleado.php';
include_once "../assets/php/Models/Usuario.php";
include_once "../assets/php/Models/Empleado.php";
include_once "../assets/php/Models/Proveedor.php";
include_once "../assets/php/Models/Compra.php";
include_once "../assets/php/Models/ProductoXCompra.php";
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
												<th>Id</th>
												<th>Nombre</th>
												<th>Cod. Barras</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="body-table-productos-proveedor">

										</tbody>
									</table>
									<a role="button" href="#" id="añadir-producto" class="btn btn-success float-right mt mr" data-target="#añadirProducto" data-toggle="modal">Añadir producto nuevo<span class="btn-label btn-label-right"><i class="fa fa-plus-square"></i></span></a>
								  	<div class="modal fade custom-modal" id="añadirProducto" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="titleAñadirProducto">Añadir producto a <span class="nombre-proveedor"></span></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form autocomplete="off" action="#" id="form-añadirProducto">
														<input type="hidden" id="input-id-proveedor"required>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Identificacion <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="input-id-producto" placeholder="Identificacion" autocomplete="off" required>
															</div>
															<div class="form-group col-md-6">
																<label>Nombre<span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="input-nombre-producto" placeholder="Nombre del producto" required>
															</div>
														</div>
														<div class="form-group">
															<label>Descripcion del producto (Opcional)</label>
															<textarea class="form-control" id="input-descripcion-producto"></textarea>
														</div>
														<div class="form-group">
															<label>Referencia de fabrica<span class="text-danger">*</span></label>
															<input type="text" class="form-control" id="input-referencia-fabrica" placeholder="Referencia de fabrica" required autocomplete="off">
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Tiene IVA? <span class="text-danger">*</span></label>
																<div class="form-check">
																  <label class="form-check-label">
																	<input class="form-check-input" type="radio" name="IVA" id="ivaSi" value="1" checked>
																	SI
																  </label>
																</div>
																<div class="form-check">
																  <label class="form-check-label">
																	<input class="form-check-input" type="radio" name="IVA" id="ivaNo" value="0">
																	NO
																  </label>
																</div>
															</div>
															<div class="form-group col-md-6">
																<label>Codigo de barras (Opcional)</label>
																<input type="text" class="form-control" id="input-codigo-barras" placeholder="Codigo de barras" autocomplete="off">
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Precio compra<span class="text-danger">*</span></label>
																<input type="number" class="form-control" id="input-precio-compra" placeholder="Precio de compra" required>
															</div>
															<div class="form-group col-md-6">
																<label>Numero de unidades<span class="text-danger">*</span></label>
																<input type="number" class="form-control" id="input-numero-unidades" placeholder="Numero de unidades" required>
															</div>
														</div>	
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-añadirProducto">Cancelar</button>
														<button type="submit" class="btn btn-success">Registrar</button>
													</form>
												</div>
											</div>
										</div>
									</div>
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
												<th scope="col">Nombre</th>
												<th scope="col">Uds</th>
												<th scope="col">PU</th>
												<th scope="col">Utilidad</th>
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

