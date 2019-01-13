<!-- Modal -->
<div class="modal fade custom-modal" id="añadirCliente" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titleAñadirCliente">Añadir a un nuevo cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form autocomplete="off" action="#" id="form-añadirCliente">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Identificación<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-id-cliente" placeholder="Identificacion" autocomplete="off" required>
						</div>
						<div class="form-group col-md-6">
							<label>Digito de verificación (Opcional)</label>
							<input type="number" class="form-control" id="input-digito-de-verificacion-cliente" placeholder="Dig. de verificación" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label>Nombre<span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="input-nombre-cliente" placeholder="Nombre" required autocomplete="off">
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label>Dirección <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-direccion-cliente" placeholder="Dirección" required>
						</div>
						<div class="form-group col-md-4">
							<label>Ciudad <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-ciudad-cliente" placeholder="Ciudad" required>
						</div>
					</div>
					<div class="form-group">
						<label>Correo electronico (Opcional)</label>
						<input type="email" class="form-control" id="input-email-cliente" placeholder="Email" autocomplete="off">
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Telefono <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-telefono-cliente" placeholder="Telefono" required>
						</div>
						<div class="form-group col-md-6">
							<label>Celular</label>
							<input type="text" class="form-control" id="input-celular-cliente" placeholder="Celular">
						</div>
					</div>
					<div class="form-group">
						<label>Clasificacion <span class="text-danger">*</span></label>
						<select class="custom-select" id="input-clasificacion-cliente" required>
							<option value="">Selecciona la clasificacion</option>
							<option value="1.-GRANDE CONTRIB">1.-GRANDE CONTRIB</option>
							<option value="2">Two</option>
							<option value="3.-REGIMEN COMUN ">3.-REGIMEN COMUN</option>
							<option value="4.-REGIMEN SIMPLI">4.-REGIMEN SIMPLI</option>
						</select>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-añadirCliente">Cancelar</button>
					<button type="submit" class="btn btn-success">Registrar</button>
				</form>
			</div>
		</div>
	</div>
</div>