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
            Swal({
              title: 'Iniciar compra',
              text: "Se iniciara una compra. El numero de factura es "+numeroFactura,
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, iniciar!',
              cancelButtonText: "No"
            }).then((result) => {
                if (result.value) {
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
                                    data=$.parseJSON(data);
                                    if(data.response==2){
                                        setTimeout(function(){
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
                                                    loadDataProveedor(idProveedor);
                                                    loadDataCompra();
                                                    $(".nombre-proveedor").html(data.nombre);
                                                    $("#input-id-proveedor").val(idProveedor);
                                                }
                                            });
                                        },200);
                                    }else{
                                       loadDataProveedor(idProveedor);
                                       loadDataCompra();
                                       $(".nombre-proveedor").html(data.nombre);
                                       $("#input-id-proveedor").val(idProveedor);
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
            {"data":"referencia_fabrica"},
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

    function loadDataCompra() {
            $.ajax({
                url: '../assets/php/Controllers/CInventario.php?method=getProductosXCompra',
                type: 'GET',
                success:function(data){ 
                  if(data!=""){
                    if(data!=3){
                        $.map($.parseJSON(data).productos, function(producto) {
                            
                        });

                    }
                  }
                  
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

    $("#cancelar-añadirProducto").click(function(){
        document.getElementById("form-añadirProducto").reset();

    });

    $("#form-añadirProducto").submit(function(event){
        event.preventDefault();
        var data;
        data = {
            "idProveedor": $("#input-id-proveedor").val(),
            "idProducto" : $("#input-id-producto").val(),
            "nombre" : $("#input-nombre-producto").val(),
            "descripcion" : $("#input-descripcion-producto").val(),
            "referenciaFabrica" : $("#input-referencia-fabrica").val(),
            "clasificacionTributaria" : "GRAVADO",
            "iva" : $('input:radio[name=IVA]:checked').val(),
            "codigoDeBarras" : $("#input-codigo-barras").val(),
            "precioCompra" : $("#input-precio-compra").val(),
            "numeroUnidades" : $("#input-numero-unidades").val()

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
                    $('input:radio[name=IVA]:checked').val(producto.tiene_iva);
                    $("#input-codigo-barras").val(producto.codigo_barras); 
                }  
            }
        });
    }




});


