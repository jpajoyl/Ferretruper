<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10">
				<h3><i class="fa fa-table"></i> Realizar venta</h3>
			</div>
		</div>
	</div>											
	<div class="card-body">
		<table id="table-productos" class="table table-bordered table-responsive-xl table-hover display">
			<thead class="cf">
				<tr class="tr-head">
					<th>Id Producto</th>
					<th>Nombre</th>
					<th>Ref Fabrica</th>
					<th>Cod. barras</th>
					<th>Unidades Totales</th>
					<th>Precio Venta</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-Productos">

			</tbody>
		</table>
		<form autocomplete="off" action="#" id="form-añadir-producto-venta">
			<table id="table-venta" class="table table-bordered table-responsive-xs table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover display">
				<thead class="cf">
					<tr class="tr-head">
						<th>Id Producto</th>
						<th>Nombre</th>
						<th>Precio venta</th>
						<th>Cantidad</th>
						<th>Total</th>					
						<th></th>
					</tr>
				</thead>
				<tbody id="body-table-venta">
					<td colspan="6" class="no-venta"><div class="alert alert-secondary mt" role="alert">
						Aun no se ha iniciado una venta. Seleccione un producto para iniciar
					</div></td>
				</tbody>
			</table>
		</form>
		<div class="row" id="div-total-venta">
			<div class="col mt mb">
				
			</div>
		</div>
		<div class="row">
			<div class="col-xs-0 col-sm-0 col-md-6 col-lg-6 col-xl-8">
				<a role="button" href="#" id="terminar-venta" class="btn btn-success float-right mt mb">Terminar venta<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></a>
				<a role="button" href="#" id="cancelar-venta" class="btn btn-danger float-right mt mr mb">Cancelar venta<span class="btn-label btn-label-right"><i class="fa fa-trash"></i></span></a>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 float-right">
				<form autocomplete="off" action="#" id="form-terminar-venta">
					<table id="table-info-venta" class="table mr table-secondary">
						<tbody>
							<tr class="tr-info-venta" id="valor-descuento">
								<th width="50%" scope="row" class="float-right">Descuento:</th>
								<td width="40%" id="descuento-venta" name="descuento-venta">0</td>
								<input type="hidden" class="form-control mb mr" id="input-descuento-venta"disabled>
							</tr>
							<tr class="tr-info-venta">
								<th width="50%" scope="row" class="float-right">Sub Total:</th>
								<td width="40%" id="subtotal-venta">0</td>
								<input type="hidden" class="form-control mb mr" id="input-subtotal-venta"disabled>
							</tr>
							<tr class="tr-info-venta">
								<th width="30%" scope="row" class="float-right">Iva:</th>
								<td width="40%" id="iva-venta">0</td>
								<input type="hidden" class="form-control mb mr" id="input-iva-venta"disabled>
							</tr>
							<tr class="tr-info-venta">
								<th width="50%" scope="row" class="float-right">Total a pagar:</th>
								<td width="40%" id="total-venta" name="total-venta" total-venta-no-modificada="">0</td>
								<input type="hidden" class="form-control mb mr" id="input-total-venta-modificada"disabled>
							</tr> 
							<tr class="tr-info-venta table-info">
								<th scope="row" class="float-right">Retefuente:</th>
								<td>
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" name="retefuente" id="input-retefuente" value="1">
										<input type="hidden" class="form-control mb mr" id="input-retefuente-venta"disabled>
										<input type="hidden" class="form-control mb mr" id="input-retefuente-valor-venta"disabled>
										Si
									</label>
								</td>
							</tr>
							<tr class="tr-info-venta table-success">
								<th width="50%" scope="row" class="float-right mt">+Descuento %:</th>
								<td width="40%" id="descuento" name="descuento">
									<input type="number" class="form-control mb mr" id="input-descuento" placeholder="3% o 5%" autocomplete="off" disabled>
								</td>
							</tr>
							<tr class="tr-info-venta table-success">
								<th width="50%" scope="row" class="float-right mt">Impresión:</th>
								<td width="40%" id="impresion">
									<select class="custom-select mb" id="input-resolucion" required>
										<option value="1">CARTA</option>
										<option value="2">POS</option>
									</select>
								</td>
							</tr>
							<tr class="tr-info-venta table-success">
								<th width="50%" scope="row" class="float-right mt">Efectivo:</th>
								<td width="40%" id="efectivo">
									<input type="number" class="form-control mb mr" id="input-efectivo" placeholder="Efectivo" autocomplete="off">
								</td>
							</tr>
							<tr class="tr-info-venta table-success" id="identificacion-usuario-venta">
								<th width="50%" scope="row" class="float-right mt">Usuario:</th>
								<td width="40%" id="usuario">
									<input type="number" class="form-control mb mr" id="input-identificacion-usuario-venta" placeholder="Identificacion" autocomplete="off">
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-cambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="content-cambio">
        <center><h2>CAMBIO: <span id="value-cambio"></span></h2></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Terminar</button>
      </div>
    </div>
  </div>
</div>