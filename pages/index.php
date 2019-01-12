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
		
		<title>Ferretruper | Home</title>
		<meta name="description" content="Free Bootstrap 4 Admin Theme | Pike Admin">
		<meta name="author" content="Pike Web Development - https://www.pikephp.com">

		<!-- Favicon -->
		<link rel="shortcut icon" href="../assets/images/favicon.ico">

		<!-- Bootstrap CSS -->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- Font Awesome CSS -->
		<link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		
		<!-- Custom CSS -->
		<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
		
		<!-- BEGIN CSS for this page -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
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
													<h1 class="main-title float-left">Pagina principal</h1>
													<ol class="breadcrumb float-right">
														<li class="breadcrumb-item">pages</li>
														<li class="breadcrumb-item active">index</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
						<!-- end row -->
							<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-default">
													<i class="fa fa-file-text-o float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Orders</h6>
													<h1 class="m-b-20 text-white counter">1,587</h1>
													<span class="text-white">15 New Orders</span>
											</div>
									</div>

									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-warning">
													<i class="fa fa-bar-chart float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Visitors</h6>
													<h1 class="m-b-20 text-white counter">250</h1>
													<span class="text-white">Bounce rate: 25%</span>
											</div>
									</div>

									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-info">
													<i class="fa fa-user-o float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Users</h6>
													<h1 class="m-b-20 text-white counter">120</h1>
													<span class="text-white">25 New Users</span>
											</div>
									</div>

									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-danger">
													<i class="fa fa-bell-o float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Alerts</h6>
													<h1 class="m-b-20 text-white counter">58</h1>
													<span class="text-white">5 New Alerts</span>
											</div>
									</div>
							</div>
							<!-- end row -->
							
							
							<div class="row">

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
										<div class="card">
											<div class="card-header">
												<h3><i class="fa fa-users"></i> Staff details</h3>
												Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus non luctus metus. Vivamus fermentum ultricies orci sit amet sollicitudin.
											</div>							
											<div class="card-body">
												<table id="example1" class="table table-bordered table-responsive-xl table-hover display">
													<thead>
														<tr>
															<th>Name</th>
															<th>Position</th>
															<th>Office</th>
															<th>Age</th>
															<th>Start date</th>
															<th>Salary</th>
														</tr>
													</thead>													
													<tbody>
														<tr>
															<td>Tiger Nixon</td>
															<td>System Architect</td>
															<td>Edinburgh</td>
															<td>61</td>
															<td>2011/04/25</td>
															<td>$320,800</td>
														</tr>
														<tr>
															<td>Garrett Winters</td>
															<td>Accountant</td>
															<td>Tokyo</td>
															<td>63</td>
															<td>2011/07/25</td>
															<td>$170,750</td>
														</tr>
														<tr>
															<td>Ashton Cox</td>
															<td>Junior Technical Author</td>
															<td>San Francisco</td>
															<td>66</td>
															<td>2009/01/12</td>
															<td>$86,000</td>
														</tr>
														<tr>
															<td>Cedric Kelly</td>
															<td>Senior Javascript Developer</td>
															<td>Edinburgh</td>
															<td>22</td>
															<td>2012/03/29</td>
															<td>$433,060</td>
														</tr>
														<tr>
															<td>Airi Satou</td>
															<td>Accountant</td>
															<td>Tokyo</td>
															<td>33</td>
															<td>2008/11/28</td>
															<td>$162,700</td>
														</tr>
														<tr>
															<td>Brielle Williamson</td>
															<td>Integration Specialist</td>
															<td>New York</td>
															<td>61</td>
															<td>2012/12/02</td>
															<td>$372,000</td>
														</tr>
														<tr>
															<td>Herrod Chandler</td>
															<td>Sales Assistant</td>
															<td>San Francisco</td>
															<td>59</td>
															<td>2012/08/06</td>
															<td>$137,500</td>
														</tr>
														<tr>
															<td>Rhona Davidson</td>
															<td>Integration Specialist</td>
															<td>Tokyo</td>
															<td>55</td>
															<td>2010/10/14</td>
															<td>$327,900</td>
														</tr>
														<tr>
															<td>Colleen Hurst</td>
															<td>Javascript Developer</td>
															<td>San Francisco</td>
															<td>39</td>
															<td>2009/09/15</td>
															<td>$205,500</td>
														</tr>
														<tr>
															<td>Sonya Frost</td>
															<td>Software Engineer</td>
															<td>Edinburgh</td>
															<td>23</td>
															<td>2008/12/13</td>
															<td>$103,600</td>
														</tr>
														<tr>
															<td>Jena Gaines</td>
															<td>Office Manager</td>
															<td>London</td>
															<td>30</td>
															<td>2008/12/19</td>
															<td>$90,560</td>
														</tr>
														<tr>
															<td>Quinn Flynn</td>
															<td>Support Lead</td>
															<td>Edinburgh</td>
															<td>22</td>
															<td>2013/03/03</td>
															<td>$342,000</td>
														</tr>										
														<tr>
															<td>Fiona Green</td>
															<td>Chief Operating Officer (COO)</td>
															<td>San Francisco</td>
															<td>48</td>
															<td>2010/03/11</td>
															<td>$850,000</td>
														</tr>
														<tr>
															<td>Shou Itou</td>
															<td>Regional Marketing</td>
															<td>Tokyo</td>
															<td>20</td>
															<td>2011/08/14</td>
															<td>$163,000</td>
														</tr>
														<tr>
															<td>Jonas Alexander</td>
															<td>Developer</td>
															<td>San Francisco</td>
															<td>30</td>
															<td>2010/07/14</td>
															<td>$86,500</td>
														</tr>
														<tr>
															<td>Shad Decker</td>
															<td>Regional Director</td>
															<td>Edinburgh</td>
															<td>51</td>
															<td>2008/11/13</td>
															<td>$183,000</td>
														</tr>
														<tr>
															<td>Michael Bruce</td>
															<td>Javascript Developer</td>
															<td>Singapore</td>
															<td>29</td>
															<td>2011/06/27</td>
															<td>$183,000</td>
														</tr>
														<tr>
															<td>Donna Snider</td>
															<td>Customer Support</td>
															<td>New York</td>
															<td>27</td>
															<td>2011/01/25</td>
															<td>$112,000</td>
														</tr>
													</tbody>
												</table>
												
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

<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/moment.min.js"></script>
		
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="../assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
	<script src="../assets/js/Chart.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>

	<!-- Counter-Up-->
	<script src="../assets/plugins/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="../assets/plugins/counterup/jquery.counterup.min.js"></script>			

	<script>
		$(document).ready(function() {
			// data-tables
			$('#example1').DataTable();
					
			// counter-up
			$('.counter').counterUp({
				delay: 10,
				time: 600
			});
		} );		
	</script>
	
	<script>
	var ctx1 = document.getElementById("lineChart").getContext('2d');
	var lineChart = new Chart(ctx1, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [{
					label: 'Dataset 1',
					backgroundColor: '#3EB9DC',
					data: [10, 14, 6, 7, 13, 9, 13, 16, 11, 8, 12, 9] 
				}, {
					label: 'Dataset 2',
					backgroundColor: '#EBEFF3',
					data: [12, 14, 6, 7, 13, 6, 13, 16, 10, 8, 11, 12]
				}]
				
		},
		options: {
						tooltips: {
							mode: 'index',
							intersect: false
						},
						responsive: true,
						scales: {
							xAxes: [{
								stacked: true,
							}],
							yAxes: [{
								stacked: true
							}]
						}
					}
	});


	var ctx2 = document.getElementById("pieChart").getContext('2d');
	var pieChart = new Chart(ctx2, {
		type: 'pie',
		data: {
				datasets: [{
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						'rgba(255,99,132,1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					label: 'Dataset 1'
				}],
				labels: [
					"Red",
					"Orange",
					"Yellow",
					"Green",
					"Blue"
				]
			},
			options: {
				responsive: true
			}
	 
	});


	var ctx3 = document.getElementById("doughnutChart").getContext('2d');
	var doughnutChart = new Chart(ctx3, {
		type: 'doughnut',
		data: {
				datasets: [{
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						'rgba(255,99,132,1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					label: 'Dataset 1'
				}],
				labels: [
					"Red",
					"Orange",
					"Yellow",
					"Green",
					"Blue"
				]
			},
			options: {
				responsive: true
			}
	 
	});
	</script>
<!-- END Java Script for this page -->

</body>
</html>