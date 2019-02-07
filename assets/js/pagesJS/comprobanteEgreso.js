$(document).ready(function() {
	$(window).load(function(){
		$("#no-factura").fadeIn(0);
	});
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
        window.table=$('#table-facturas-proveedor').DataTable({
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
            {"defaultContent":"<button class='btn btn-primary btn-xs añadir-factura'><i class='fa fa-plus'></i></button>"}
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
        añadirFactura("#body-table-factura-compra", table);
    }

    function añadirFactura(tbody,table){
        $(tbody).on("click", ".añadir-factura", function(){
            var data=table.row($(this).parents("tr")).data();
            var añadirFactura=true;
            $("#table-venta tbody tr").each(function(){
                if($(this).attr("id-factura")==data.idfactura_compra){
                    añadirFactura=false;
                }
            });
            if(añadirFactura){
                var tbody='<tr id="añadir-factura-compra" id-factura="'+data.idfactura_compra+'">'+
                        '<td width="15%" id="td-id-producto">'+
                            data.idfactura_compra+'<input type="hidden" id="input-id-factura-venta" value="'+data.idFactura_compra+'">'+
                        '</td>'+
                        '<td>'+
                            data.numero_factura+
                        '</td>'+
                        '<td>'+
                            data.fecha_compra+
                        '</td>'+
                        '<td>'+
                            '<center><button class="btn btn-danger btn-xs eliminar-factura-compra"><i class="fa fa-trash"></i></button></button></center>'+
                        '</td></tr>';
                $("#no-factura").fadeOut(0);
                $("#body-table-comprobante-egreso").append(tbody);
            }
        });
    }
    $(document).on("click", ".eliminar-factura-compra", function(){
        $(this).closest('tr').remove();
        if($("#body-table-comprobante-egreso tr").length==1){
            $("#no-factura").fadeIn(0);
        }
    });

});