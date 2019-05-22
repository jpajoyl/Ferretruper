<div class="modal fade custom-modal" id="añadirEmpleado" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titleAñadirEmpleado">Añadir a un nuevo empleado</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form autocomplete="off" action="#" id="form-añadirEmpleado">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Identificación<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-id-empleado" placeholder="Identificacion" autocomplete="off" required>
						</div>
						<div class="form-group col-md-6">
							<label>Nombre<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-nombre-empleado" placeholder="Nombre" required autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label>Dirección <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-direccion-empleado" placeholder="Dirección" required>
						</div>
						<div class="form-group col-md-4">
							<label>Ciudad <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-ciudad-empleado" placeholder="Ciudad" required>
						</div>
					</div>
					<div class="form-group">
						<label>Correo electronico (Opcional)</label>
						<input type="email" class="form-control" id="input-email-empleado" placeholder="Email" autocomplete="off">
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Usuario<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-usuario-empleado" placeholder="Usuario" required autocomplete="off" pattern="[A-Za-z0-9]+">
						</div>
						<div class="form-group col-md-6">
							<label>Contraseña<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-contrasena-empleado" placeholder="Contraseña" required autocomplete="off" pattern="[A-Za-z0-9]+">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Telefono <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="input-telefono-empleado" placeholder="Telefono" pattern="[0-9]+" required>
						</div>
						<div class="form-group col-md-6">
							<label>Celular</label>
							<input type="text" class="form-control" id="input-celular-empleado"  pattern="[0-9]+" placeholder="Celular">
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-añadirEmpleado">Cancelar</button>
					<button type="submit" class="btn btn-success">Registrar</button>
				</form>
			</div>
		</div>
	</div>
</div>