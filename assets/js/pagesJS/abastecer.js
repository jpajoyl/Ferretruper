$(document).ready(function() {
	    
    $("#input-nombre-o-nit").autocomplete({
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
            	var numeroFactura=$("#input-numero-factura").val();
            	if(numeroFactura==""){
            		Swal(
            		  'Aviso!',
            		  'Digite el numero de la factura',
            		  'info'
            		  );
            	}else{
            		$("#form-abastecer").submit();
            	}
            },100);      
        }

    });

    $("#form-abastecer").submit(function(event){
    	event.preventDefault();
    	var numeroFactura=$("#input-numero-factura").val();
    	var idProveedor=$("#id-proveedor").val();
    	if(numeroFactura=="" || idProveedor==""){
    		Swal(
    		  'Error!',
    		  'Falta un campo por llenar',
    		  'error'
    		  );
    	}else{

    		var data={
    			"numeroFactura":numeroFactura,
    			"idProveedor":idProveedor
    		}
    		$.ajax({
                url: '../assets/php/Controllers/CInventario.php?method=iniciarCompra',
                type: 'POST',
                data: data,
                success:function(data){
                    if(data!=""){
                    	if(data!=0){
                            if(data==2){
                                Swal({
                                  title: 'Error',
                                  text: "Al parecer esta compra ya esta registrada, esta seguro que el numero de factura es "+numeroFactura+"!",
                                  type: 'error',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Si, seguir abasteciendo compra!',
                                  cancelButtonText: "No"
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.href = "abastecer.php?";
                                    }
                                });
                            }
                        }else{
                            Swal(
                              'Error!',
                              'Ha ocurrido un error, recargue la pagina y vuelva a intentar',
                              'error'
                              );
                        }
                    }  
                }
            });
    	}
    });

    $('#form-abastecer').bind("keypress", function(e) { 
	    if (e.keyCode == 13) {    
		    $(this).submit();
		    return false; 
	    } 
	}); 

    function loadDataProveedor(idProveedor){
        window.tableProductos=$('#table-productos-proveedor').DataTable({
            "ajax":{
                "method":"POST",
                "data": {
                    "idProveedor": idProveedor
                },
                "url":"../assets/php/Controllers/CProveedor.php?method=productosProveedor"
            },
            "dataSrc": function(dataReturn){
                if(dataReturn == 3){
                    return [];
                }
                else {
                    return dataReturn.data;
                }
            },
            "autoWidth": false,
            "columns":[
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {"data":"id_producto"},
            {"data":"nombre"},
            {"data":"codigo_barras"},
            {"defaultContent":"<button class='btn btn-primary btn-xs editar-producto'><i class='fa fa-pencil'></i></button>\
            </button><button class='btn btn-success btn-xs comprar-producto'><i class='fa fa-arrow-circle-right'></i></button>"}
            ],
            "destroy":true,
            "responsive":true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se han encontrado registros",
                "info": "(_MAX_ productos) Pagina _PAGE_ de _PAGES_",
                "search": "Buscar",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(registros disponibles _MAX_)"
            }
        });
    }

    function formatDataProveedor (data) {
        var iva="Si";
        if(data.tiene_iva==0){
            iva="No";
        }
        return '<div class="row">'+
        '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
        '<i><i class="fa fa-circle"></i><strong> Descripcion: </strong>'+data.descripcion+'</i>'+
        '</div>'+
        '</div>'+
        '<div class="row">'+
        '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
        '<i><i class="fa fa-money"></i><strong> Iva: </strong>'+iva+'</i>'+
        '</div>'+
        '</div>';
    }

    $('#table-productos-proveedor tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableProductos.row( tr );

        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( formatDataProveedor(row.data()) ).show();
            tr.addClass('shown');
        }
    });


});


