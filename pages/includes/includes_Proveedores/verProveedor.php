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
			<div class="card-header productos-suministrados" role="tab" id="headingTwo">
			  <h5 class="mb-0">
				<a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				  Productos suministrados
				</a>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
			  <div class="card-body">
			  	<a role="button" href="#" id="añadir-producto" class="btn btn-success float-right" data-target="#añadirProducto" data-toggle="modal">Añadir producto<span class="btn-label btn-label-right"><i class="fa fa-product-hunt"></i></span></a>
			  	<div class="modal fade custom-modal" id="añadirProducto" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="titleAñadirProducto">Añadir producto a <?php echo $proveedor->getNombre(); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form autocomplete="off" action="#" id="form-añadirProducto">
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
										<label>Descripcion del producto<span class="text-danger">*</span></label>
										<textarea required class="form-control" id="input-descripcion-producto"></textarea>
									</div>
									<div class="form-group">
										<label>Referencia de fabrica<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="input-referencia-fabrica" placeholder="Referencia de fabrica" required autocomplete="off">
									</div>
									<div class="form-group">
										<label>Clasificacion Tributaria<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="input-clasificacion-tributaria" placeholder="Clasificacion Tributaria" required value="GRAVADO" autocomplete="off">
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>Valor de utilidad <span class="text-danger">*</span></label>
											<input type="number" class="form-control" id="input-valor-utilidad" placeholder="Valor Utilidad" value="30" required>
										</div>
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
									</div>	
									<div class="form-group">
										<label>Codigo de barras (Opcional)</label>
										<input type="text" class="form-control" id="input-codigo-barras" placeholder="Codigo de barras" autocomplete="off">
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
				<table id="table-productos-proveedor" class="table table-bordered table-striped table-responsive-xl table-hover display">
					<thead class="cf">
						<tr>
							<th></th>
							<th>No. producto</th>
							<th>Cod. Barras</th>
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
				<!-- Modal -->
				<div class="modal fade custom-modal" id="modal-editar-producto" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="titleEditarProducto">Editar Producto: <span id="nombre-producto"></span></span></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form autocomplete="off" action="#" id="form-editarProducto">
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>Identificacion <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-id-producto-editar" placeholder="Identificacion" autocomplete="off" required disabled>
										</div>
										<div class="form-group col-md-6">
											<label>Nombre<span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-nombre-producto-editar" placeholder="Nombre del producto" autocomplete="off" required>
										</div>
									</div>
									<div class="form-group">
										<label>Descripcion del producto<span class="text-danger">*</span></label>
										<textarea required class="form-control" id="input-descripcion-producto-editar"></textarea>
									</div>
									<div class="form-group">
										<label>Referencia de fabrica<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="input-referencia-fabrica-editar" placeholder="Referencia de fabrica" required autocomplete="off">
									</div>
									<div class="form-group">
										<label>Clasificacion Tributaria<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="input-clasificacion-tributaria-editar" placeholder="Clasificacion Tributaria" required value="GRAVADO" autocomplete="off">
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>Valor de utilidad <span class="text-danger">*</span></label>
											<input type="number" class="form-control" id="input-valor-utilidad-editar" placeholder="Valor Utilidad" value="30" required>
										</div>
										<div class="form-group col-md-6">
											<label>Tiene IVA? <span class="text-danger">*</span></label>
											<div class="form-check">
											  <label class="form-check-label">
												<input class="form-check-input" type="radio" name="IVA-editar" id="ivaSi" value="1" checked>
												SI
											  </label>
											</div>
											<div class="form-check">
											  <label class="form-check-label">
												<input class="form-check-input" type="radio" name="IVA-editar" id="ivaNo" value="0">
												NO
											  </label>
											</div>
										</div>
									</div>	
									<div class="form-group">
										<label>Codigo de barras (Opcional)</label>
										<input type="text" class="form-control" id="input-codigo-barras-editar" placeholder="Codigo de barras" autocomplete="off">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-editarProducto">Cancelar</button>
									<button type="submit" class="btn btn-success">Editar</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>													
</div><!-- end card-->


    

