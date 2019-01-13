<?php 
$proveedor=$servletRequest->getAtribute("proveedor");
 ?>
<div class="card" id="card-verProveedor" id-proveedor="<?php echo $proveedor->getIdUsuario(); ?>">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h3><i class="fa fa-angle-right"></i> Informacion de <?php echo $proveedor->getNombre(); ?></h3>
			</div>
		</div>
	</div>							
	<div class="card-body">
		<div id="accordion" role="tablist">
		  <div class="card">
			<div class="card-header" role="tab" id="headingOne">
			  <h5 class="mb-0">
				<a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				  Informacion
				</a>
			  </h5>
			</div>

			<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
			  <div class="card-body">
			  	<div class="row">
			  		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<ul class="list-group" style="font-size: large">
						    <a  class="list-group-item" id="id-usuario" >
						        <b>No. proveedor: </b><span id="valor-id-usuario"><?php echo $proveedor->getIdUsuario(); ?></span>
						    </a>
						    <a  class="list-group-item" id="tipo-identificacion" >
						        <b>Tipo identificacion: </b><span id="valor-tipo-identificacion"><?php echo $proveedor->getTipoDeIdentificacion(); ?></span>
						    </a>
						    <a  class="list-group-item" id="numero-identificacion" >
						        <b>No. identificacion: </b><span id="valor-numero-identificacion"><?php echo $proveedor->getNumeroDeIdentificacion(); ?></span>
						    </a>
						    <a  class="list-group-item" id="digito-de-verificacion" >
						        <b>Dig. verificacion: </b><span id="valor-digito-de-verificacion"><?php echo $proveedor->getDigitoDeVerificacion(); ?></span>
						    </a>
						    <a  class="list-group-item" id="nombre" >
						        <b>No. proveedor: </b><span id="valor-nombre"><?php echo $proveedor->getNombre(); ?></span>
						    </a>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<ul class="list-group" style="font-size: large">
						    <a  class="list-group-item" id="direccion" >
						        <b>Direccion: </b><span id="valor-direccion"><?php echo $proveedor->getDireccion(); echo " - ".$proveedor->getCiudad(); ?></span>
						    </a>
						    <a  class="list-group-item" id="clasificacion" >
						        <b>Clasificacion: </b><span id="valor-clasificacion"><?php echo $proveedor->getClasificacion(); ?></span>
						    </a>
						    <a  class="list-group-item" id="email" >
						        <b>Email: </b><span id="valor-email"><?php echo $proveedor->getEmail(); ?></span>
						    </a>
						    <a  class="list-group-item" id="celular" >
						        <b>Celular: </b><span id="valor-celular"><?php echo $proveedor->getCelular(); ?></span>
						    </a>
						    <a  class="list-group-item" id="telefono" >
						        <b>Telefono: </b><span id="valor-telefono"><?php echo $proveedor->getTelefono(); ?></span>
						    </a>
						</ul>
					</div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" role="tab" id="headingTwo">
			  <h5 class="mb-0">
				<a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				  Productos suministrados
				</a>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
			  <div class="card-body">
			  	<a role="button" href="#" id="añadir-proveedor" class="btn btn-success float-right" data-target="#añadirProveedor" data-toggle="modal">Añadir proveedor<span class="btn-label btn-label-right"><i class="fa fa-user-plus"></i></span></a>
						<table id="table-productos-proveedor" class="table table-bordered table-striped table-responsive-xl table-hover display">
							<thead class="cf">
								<tr>
									<th></th>
									<th>No. producto</th>
									<th>Nombre</th>
									<th>Ref. Fabrica</th>
									<th>C. Tributaria</th>
									<th>% Utilidad</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="body-table-productos-proveedor">

							</tbody>
						</table>
			  </div>
			</div>
		  </div>
		</div>
	</div>													
</div><!-- end card-->


    

