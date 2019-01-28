$(document).ready(function() {
	$("#input-proveedor").autocomplete({
		source: function(request,response){
			$.ajax({
				url: '../assets/php/Controllers/CProveedor.php?method=buscarNombreONit',
				type: 'POST',
				data: {"valor":request.term},
				success:function(data){
					if(data!=""){
						if(data!=3){
							var array = data.error ? [] : $.map($.parseJSON(data).info, function(m) {
								return {
									label: m.numero_identificacion+"-"+m.nombre,
									id: m.id_usuario
								};	
							});
							response(array);
						}else{
							var array=[];
							response(array);
						}
					}  
				}
			});
		},select: function (event, ui) {
			$("#id-proveedor").val(ui.item.id);
			setTimeout(function(){
				$("#form-factura-compra").submit(); 
			},50);  
		}

	});

	$("#form-factura-compra").submit(function(event){
		event.preventDefault();
		var idProveedor=$("#id-proveedor").val();
		if(idProveedor==""){
			Swal(
				'Error!',
				'Falta un campo por llenar',
				'error'
				);
		}else{
			loadData(idProveedor);
		}
	});

	function loadData(idProveedor){
        window.facturas=$('#table-facturas-proveedor').DataTable({
            "ajax":{
                "method":"POST",
                "data": {
                    "idProveedor": idProveedor
                },
                "url":"../assets/php/Controllers/CComprobanteEgreso.php?method=buscarFacturaCompra",
                "dataSrc": function(dataReturn){
                    if(dataReturn == 3){
                        return [];
                    }
                    else {
                        return dataReturn.data;
                    }
                }
            },
            "autoWidth": false,
            "columns":[
            {"data":"idfactura_compra"},
            {"data":"numero_factura"},
            {"data":"fecha_compra"},
            {"defaultContent":"<button class='btn btn-primary btn-xs editar-producto'><i class='fa fa-plus'></i></button>"}
            ],
            "destroy":true,
            "responsive":true,
            "language": {
                "lengthMenu": "Mostrar _MENU_",
                "zeroRecords": "No se han encontrado registros",
                "info": "(_MAX_ productos) Pagina _PAGE_ de _PAGES_",
                "search": "Buscar",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(registros disponibles _MAX_)"
            }
        });
        comprarProducto("#table-productos-proveedor tbody",tableProductos);
        getDataEditProducto("#table-productos-proveedor tbody",tableProductos);
    }


});