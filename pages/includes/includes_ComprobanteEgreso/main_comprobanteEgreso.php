<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10">
				<h3><i class="fa fa-users"></i> Inventario actual</h3>
			</div>
			</div>
		</div>
	<div class="card-body">
		<table id="table-facturas-proveedor" class="table table-bordered table-responsive-xl table-hover display">
			<thead class="cf">
				<tr>
					<th>Id factura de Compra</th>
					<th>Numero de Factura</th>
					<th>fecha de la factura de compra</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-factura-compra">

			</tbody>
		</table>
		<table id="table-venta" class="table table-bordered table-responsive-xs table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover display mt">
			<thead class="cf">
				<tr class="tr-head">
					<th>Id factura de Compra</th>
					<th>Numero de Factura</th>
					<th>Fecha</th>				
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-comprobante-egreso">
				<tr id="no-factura">
					<td colspan="4"><div class="alert alert-secondary mt" role="alert">
					  Aun no se ha iniciado el proceso, seleccione una factura para emitir el comprobante
					</div></td>
				</tr>
			</tbody>
		</table>
		<div class="row" id="div-total-venta">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10 mt mb">
				<b class="info-total-venta float-right mr">Total de comprobante:</b>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 mt mb">
				<b class="info-total-venta">$<span id="total-preCompra"></span></b>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<a role="button" href="#" id="enviar-factura-compra" class="btn btn-info float-right mr">Enviar<span class="btn-label btn-label-right"><i class="fa fa-pencil"></i></span></a>
			</div>
		</div>
		<!-- Modal -->
	</div>
</div>