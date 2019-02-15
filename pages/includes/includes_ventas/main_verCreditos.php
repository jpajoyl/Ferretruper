<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10">
				<h3><i class="fa fa-users"></i> Creditos</h3>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
				<a role="button" href="#" id="ver-pagados" class="btn btn-success float-right mr">Pagados<span class="btn-label btn-label-right"><i class="fa fa-credit-card"></i></span></a>
				<a role="button" href="#" id="volver-principal" class="btn btn-info float-right mr">Regresar<span class="btn-label btn-label-right"><i class="fa fa-backward"></i></span></a>
			</div>
		</div>
	</div>											
	<div class="card-body">
		<table id="table-creditos" class="table table-bordered table-responsive-xl table-hover display">
			<thead class="cf">
				<tr>
					<th></th>
					<th></th>
					<th>No venta</th>
					<th>Cliente</th>
					<th>Valor</th>
					<th>Fecha ini/fin</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-creditos">

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
								<label>Descripcion del producto (Opcional)</label>
								<textarea class="form-control" id="input-descripcion-producto-editar"></textarea>
							</div>
							<div class="form-group">
								<label>Referencia de fabrica<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="input-referencia-fabrica-editar" placeholder="Referencia de fabrica" required autocomplete="off">
							</div>
							<div class="form-row">
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
								<div class="form-group col-md-6">
									<label>Codigo de barras (Opcional)</label>
								<input type="text" class="form-control" id="input-codigo-barras-editar" placeholder="Codigo de barras" autocomplete="off">
								</div>
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