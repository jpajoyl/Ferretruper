<?php
include_once '../assets/php/Conexion.php';
include_once '../assets/php/Controllers/SesionEmpleado.php';
include_once "../assets/php/Models/Usuario.php";
include_once "../assets/php/Models/Empleado.php";
include_once '../assets/php/Controllers/GetSession.php';
include_once '../assets/php/Controllers/HttpServletRequest.php';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>JUANES X2</title>
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
										<h1 class="main-title float-left">Proveedores</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">pages</li>
											<li class="breadcrumb-item active">proveedores</li>
										</ol>
										<div class="clearfix"></div>
								</div>
						</div>
				</div>
				<!-- end row -->

				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">									
					  	<?php 
					  		$page=isset($_GET['p'])?$_GET['p']:"";
					  		if($page==""){
					  			include 'includes/includes_Proveedores/main_proveedores.php';
					  		}else if($page=="verProveedor"){
					  			$id=isset($_GET['id'])?$_GET['id']:"";
					  			if($id!=""){
					  				$include=False;
					  				$method="verProveedor";	
					  				$servletRequest = new HttpServletRequest();
					  				include_once '../assets/php/Models/Proveedor.php';
					  				include_once'../assets/php/Controllers/CProveedor.php';
					  				if($servletRequest->getAtribute("proveedor") instanceof Proveedor){
					  					include 'includes/includes_Proveedores/verProveedor.php';
					  				}else{
					  					include '404.php';
					  				}
					  			}else{
					  				include '404.php';
					  			}
					  		}
					  	 ?>
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
<script src="../assets/js/pagesJS/proveedor.js"></script>
<!-- END Java Script for this page -->

</body>
</html>