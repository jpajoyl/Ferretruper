>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> HTML <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
<link rel="stylesheet" href="../assets/css/jquery-ui.css">
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
<script src="../assets/js/jquery-ui.js"></script>
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> JAVASCRIPT <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$("#cancelar-añadirProducto").click(function(){
    document.getElementById("form-añadirProducto").reset();

});

$("#form-añadirProducto").submit(function(event){
    event.preventDefault();
    var data;
    data = {
        "idProveedor": $("#card-verProveedor").attr("id-proveedor"),
        "idProducto" : $("#input-id-producto").val(),
        "nombre" : $("#input-nombre-producto").val(),
        "descripcion" : $("#input-descripcion-producto").val(),
        "referenciaFabrica" : $("#input-referencia-fabrica").val(),
        "clasificacionTributaria" : $("#input-clasificacion-tributaria").val(),
        "utilidad" : $("#input-valor-utilidad").val(),
        "iva" : $('input:radio[name=IVA]:checked').val(),
        "CodigoDeBarras" : $("#input-codigo-barras").val()
    }
    $.ajax({
        url: '../assets/php/Controllers/CProducto.php?method=registrarProducto',
        type: 'POST',
        data: data,
        success:function(data){ 
          if(data!=""){
            if(data==1){
                $("#añadirProducto").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Satisfactorio!',
                      'Se ha registrado correctamente el producto',
                      'success'
                      );
                    document.getElementById("form-añadirProducto").reset();
                    loadDataProveedor(); 
                },500); 
            }else if(data==0){
                $("#añadirProducto").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'Ha ocurrido un error, vuelva a intentar',
                      'error'
                      );
                    document.getElementById("form-añadirProducto").reset();
                    loadDataProveedor();  
                },500);
            }else if(data==2){
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'Al parecer este numero de identificacion ya esta registrado',
                      'error'
                      );
                },500);
            }else if(data==3){
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'No se ha encontrado el proveedor, recargue la pagina y vuelva a intentarlo',
                      'error'
                      );
                },500);
            }
        }
    }   
});

});

$("#input-nombre-producto").autocomplete({
    source: function(request,response){
        $.ajax({
            url: '../assets/php/Controllers/CProducto.php?method=buscarNombre',
            type: 'POST',
            data: {"nombre":request.term},
            success:function(data){
                if(data!=""){
                    var array = data.error ? [] : $.map($.parseJSON(data).info, function(m) {
                        return {
                            label: m.nombre,
                            id: m.id_producto
                        };
                    });
                    response(array);
                }  
            }
        });
    },select: function (event, ui) {
        setTimeout(function(){
            buscarProductoAñadir(ui.item.id);
        },100);      
    }

});

function buscarProductoAñadir(idProducto){
    $.ajax({
        url: '../assets/php/Controllers/CProducto.php?method=buscarProducto',
        type: 'POST',
        data: {"idProducto":idProducto},
        success:function(data){
            if(data!=""){
                var producto=$.parseJSON(data);
                $("#input-id-producto").val(producto.id_producto);
                $("#input-descripcion-producto").val(producto.descripcion);
                $("#input-referencia-fabrica").val(producto.referencia_fabrica);
                $("#input-clasificacion-tributaria").val(producto.clasificacion_tributaria);
                $("#input-valor-utilidad").val(producto.valor_utilidad);
                $('input:radio[name=IVA]:checked').val(producto.tiene_iva);
                $("#input-codigo-barras").val(producto.codigo_barras); 
            }  
        }
    });
}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> PHP <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
