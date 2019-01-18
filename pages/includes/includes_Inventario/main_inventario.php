<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10">
				<h3><i class="fa fa-users"></i> Inventario actual</h3>
			</div>
				<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
					<a role="button" href="#" id="añadir-producto" class="btn btn-success float-right" data-target="#añadirProducto" data-toggle="modal">Añadir Producto<span class="btn-label btn-label-right"><i class="fa fa-user-plus"></i></span></a>
			</div>
		</div>
	</div>
	<!-- Modal -->
			<div class="modal fade custom-modal" id="añadirProducto" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="titleAñadirProducto">Añadir a un nuevo Producto</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form autocomplete="off" action="#" id="form-añadirProducto">
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>NIT <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-nit" placeholder="NIT" autocomplete="off" required>
										</div>
										<div class="form-group col-md-6">
											<label>Digito de verificación <span class="text-danger">*</span></label>
											<input type="number" class="form-control" id="input-digito-de-verificacion" placeholder="Dig. de verificación" autocomplete="off" required>
										</div>
									</div>
									<div class="form-group">
										<label>Nombre de la empresa <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="input-nombre" placeholder="Nombre" required autocomplete="off">
									</div>
									<div class="form-row">
										<div class="form-group col-md-8">
											<label>Dirección <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-direccion" placeholder="Dirección" required>
										</div>
										<div class="form-group col-md-4">
											<label>Ciudad <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-ciudad" placeholder="Ciudad" required>
										</div>
									</div>
									<div class="form-group">
										<label>Correo electronico <span class="text-danger">*</span></label>
										<input type="email" class="form-control" id="input-email" placeholder="Email" required autocomplete="off">
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>Telefono <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="input-telefono" placeholder="Telefono" required>
										</div>
										<div class="form-group col-md-6">
											<label>Celular</label>
											<input type="text" class="form-control" id="input-celular" placeholder="Celular">
										</div>
									</div>
									<div class="form-group">
										<label>Clasificacion <span class="text-danger">*</span></label>
										<select class="custom-select" id="input-clasificacion" required>
											<option value="">Selecciona la clasificacion</option>
											<option value="1.-GRANDE CONTRIB">1.-GRANDE CONTRIB</option>
											<option value="2">Two</option>
											<option value="3.-REGIMEN COMUN ">3.-REGIMEN COMUN</option>
											<option value="4.-REGIMEN SIMPLI">4.-REGIMEN SIMPLI</option>
									    </select>
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
		</div>
	</div>												
	<div class="card-body">
		<table id="table-productos" class="table table-bordered table-striped table-responsive-xl table-hover display">
			<thead class="cf">
				<tr>
					<th></th>
					<th>Id Producto</th>
					<th>Nombre</th>
					<th>Ref Fabrica</th>
					<th>IVA</th>
					<th>C Tributaria</th>
					<th>Unidades Totales</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-Productos">

			</tbody>
		</table>
	</div>
</div>