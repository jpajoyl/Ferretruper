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
					<th>Precio venta</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="body-table-Productos">

			</tbody>
		</table>
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
				<!-- <tr id="añadir-producto-venta">
					<form autocomplete="off" action="#" id="form-añadir-producto-venta">
						<td width="15%" id="td-id-producto"><input type="number" class="form-control" id="input-id-producto" placeholder="id producto" autocomplete="off"></td>
					</form>
				</tr> -->
				<td colspan="6"><div class="alert alert-secondary mt" role="alert">
				  Aun no se ha iniciado una compra. Seleccione un producto para iniciar
				</div></td>
			</tbody>
		</table>
		<div class="row" id="div-total-venta">
			<div class="col-xs-6 col-sm-6 col-md-8 col-lg-10 col-xl-10 mt mb">
				<b class="info-total-venta float-right mr">Total de venta:</b>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 mt mb">
				<b class="info-total-venta">$<span id="total-preCompra"></span></b>
			</div>
		</div>
	</div>
</div>