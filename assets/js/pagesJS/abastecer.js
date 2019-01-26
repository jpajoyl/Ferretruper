$(document).ready(function() {

  $(window).load(function(){
      $.ajax({
          url: '../assets/php/Controllers/CInventario.php?method=obtenerIva',
          type: 'POST',
          success:function(data){
              if(data!=""){
                window.iva=parseFloat(data);
                $("#valor-iva").html(window.iva*100+"%");
              }  
          }
      });
    });

	    
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
                                              title: 'Continuar comprando',
                                              text: "Al parecer esta compra ya esta registrada, esta seguro que el numero de factura es "+numeroFactura+"!",
                                              type: 'info',
                                              showCancelButton: true,
                                              confirmButtonColor: '#3085d6',
                                              cancelButtonColor: '#d33',
                                              confirmButtonText: 'Si, seguir abasteciendo compra!',
                                              cancelButtonText: "No"
                                            }).then((result) => {
                                                if (result.value) {
                                                    $("#alert-informacion").fadeOut(100);
                                                    $("#card-productos-proveedor").fadeIn(100);
                                                    $("#card-productos-compra").fadeIn(100);
                                                    loadDataProveedor(idProveedor);
                                                    loadDataCompra();
                                                    $(".nombre-proveedor").html(data.nombre);
                                                    $("#input-id-proveedor").val(idProveedor);
                                                }
                                            });
                                        },200);
                                    }else if(data.response==1){
                                      $("#alert-informacion").fadeOut(100);
                                      $("#card-productos-proveedor").fadeIn(100);
                                      $("#card-productos-compra").fadeIn(100);
                                      loadDataProveedor(idProveedor);
                                      loadDataCompra();
                                      $(".nombre-proveedor").html(data.nombre);
                                      $("#input-id-proveedor").val(idProveedor);
                                    }else if(data.response==0){
                                      Swal(
                                      'Error!',
                                      'Parece que esta factura ya la habias finalizado. No podemos continuar',
                                      'error'
                                      );
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
            {"defaultContent":"<button class='btn btn-primary btn-xs editar-producto'><i class='fa fa-pencil'></i></button>\
            </button><button class='btn btn-success btn-xs comprar-producto'><i class='fa fa-arrow-circle-right'></i></button>"}
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

    function comprarProducto(tbody,table){
        $(tbody).on("click", ".comprar-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            $.ajax({
                url: '../assets/php/Controllers/CInventario.php?method=añadirProductoxcompra',
                type: 'POST',
                data:{"idProducto":data.id_producto},
                success:function(data){ 
                  if(data!=""){
                    if(data==1){
                      loadDataCompra();
                    }else if(data==0 || data==3){
                      Swal(
                        'Error!',
                        'Ha ocurrido un error, recargue la pagina y vuelva a intentar',
                        'error'
                        );
                    }else if(data==2){
                      Swal(
                        'Error!',
                        'Parece que ya has agregado ese producto!',
                        'error'
                        );
                    }
                  }
                }   
            });
        });
    }

    function dinamizarCompra(tbody){
      $(tbody).on("change keyup",".input-compra",function(){
        calcularValorVenta($(this).attr("id-productoxcompra"));
      });

      $(tbody).on("change keyup",".input-pv",function(){
        calcularValorUtilidad($(this).attr("id-productoxcompra"),parseInt($(this).val()));
      });

      $(tbody).on("click",".eliminar-producto",function(event){
        event.preventDefault();
        Swal({
          title:'Eliminar producto',
          text: "Seguro que desea eliminar el "+$(".nombre-producto-compra[id-productoxcompra="+$(this).attr("id-productoxcompra")+"]").html(),
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',  
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: "No"
        }).then((result) => {
            if (result.value) {
                var data={
                    "idProductoxcompra":$(this).attr("id-productoxcompra")
                }
                $.ajax({
                    url: '../assets/php/Controllers/CInventario.php?method=eliminarProductoxcompra',
                    type: 'POST',
                    data: data,
                    success:function(data){
                        if(data!=""){
                            if(data==1){
                              loadDataCompra();
                            }else if(data==0 || data==3){
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
      });

    }

    function loadDataCompra() {
      $("#table-productos-compra > tbody").html("");
            $.ajax({
                url: '../assets/php/Controllers/CInventario.php?method=getProductosXCompra',
                type: 'GET',
                success:function(data){ 
                  if(data!=""){
                    if(data!=3){ 
                        $.map($.parseJSON(data).productos, function(producto) {
                            var tbody='<tr id-productoxcompra="'+producto.id_productoxcompra+'">'+
                              '<td width="20%" class="nombre-producto-compra" id-productoxcompra="'+producto.id_productoxcompra+'">'+producto.nombre+'</td>'+
                              '<td width="15%"><input type="number" class="form-control input-compra input-pu" id-productoxcompra="'+producto.id_productoxcompra+'" placeholder="PU" autocomplete="off" required value="'+producto.precio_unitario+'"></td>'+
                              '<td width="11%"><input type="number" class="form-control input-compra input-uds" id-productoxcompra="'+producto.id_productoxcompra+'" placeholder="Uds" autocomplete="off" required value="'+producto.unidades+'"></td>'+
                              '<td width="11%"><input type="text" class="form-control input-compra input-utilidad" id-productoxcompra="'+producto.id_productoxcompra+'" placeholder="Utilidad" autocomplete="off" required value="30"></td>'+
                              '<input type="hidden" class="input-iva" id-productoxcompra="'+producto.id_productoxcompra+'">'+
                              '<td width="15%"><input type="text" class="form-control input-pv" id-productoxcompra="'+producto.id_productoxcompra+'" placeholder="PV" autocomplete="off" required value="'+obtenerPrecioVenta(producto.precio_unitario,30,false)+'" '+obtenerPrecioVenta(producto.precio_unitario,30,true)+'></td>'+
                              '<td width="5%"><button class="btn btn-danger btn-xs eliminar-producto" id-productoxcompra="'+producto.id_productoxcompra+'"><i class="fa fa-trash"></i></button></td>'+
                              '</tr>';
                            $("#table-productos-compra > tbody").append(tbody);
                        });

                        dinamizarCompra("#table-productos-compra > tbody");
                    }
                  }
                  
                }   
        });
    }

    function obtenerPrecioVenta(precioUnitario,utilidad,returnDisabled){
      var precioVenta=precioUnitario*(1+(utilidad/100))+precioUnitario*(1+(utilidad/100))*window.iva;
      if(!returnDisabled){
        return (precioVenta);
      }else{
        if(precioVenta==0){
          return "disabled";
        }
      }
    }

    function calcularValorVenta(idProductoxcompra){
      var precioUnitario=parseInt($(".input-pu[id-productoxcompra="+idProductoxcompra+"]").val());
      var unidades=parseInt($(".input-uds[id-productoxcompra="+idProductoxcompra+"]").val());
      var utilidad=parseInt($(".input-utilidad[id-productoxcompra="+idProductoxcompra+"]").val());
      var precioVenta=obtenerPrecioVenta(precioUnitario,utilidad,false);
      $(".input-pv[id-productoxcompra="+idProductoxcompra+"]").val(precioVenta);
      if(precioVenta>0 && unidades>0){
        $(".input-pv[id-productoxcompra="+idProductoxcompra+"]").removeAttr("disabled");
      }else{
        $(".input-pv[id-productoxcompra="+idProductoxcompra+"]").attr("disabled");
      }
    }

    function calcularValorUtilidad(idProductoxcompra,precioVenta) {
      if(precioVenta>=0){
        var precioUnitario=parseInt($(".input-pu[id-productoxcompra="+idProductoxcompra+"]").val());
        var utilidad=((precioVenta-(1+window.iva)*precioUnitario)/((1+window.iva)*precioUnitario)*100).toFixed(2);
        $(".input-utilidad[id-productoxcompra="+idProductoxcompra+"]").val(utilidad);
      }else{
        calcularValorVenta(idProductoxcompra);
      }
    }

    $("#data-compra").submit(function(event){
      event.preventDefault();
      Swal({
        title:'Abastecer',
        text: "Al aceptar confirma que los datos de compra son correctos. ¿Esta seguro que desea abastecer?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',  
        confirmButtonText: 'Si, abastecer!',
        cancelButtonText: "No"
      }).then((result) => {
          if (result.value) {
              var data = [];
              $("#table-productos-compra tbody tr").each(function(e){
                var producto = new Object();
                producto.id_productoxcompra=$(this).attr("id-productoxcompra");
                $(this).children("td").each(function(e){
                  var inputPU = $(this).find('.input-pu');
                  var inputUds = $(this).find('.input-uds');
                  var inputUtilidad = $(this).find('.input-utilidad');
                  var inputPV = $(this).find('.input-pv');
                  if (inputPU[0]){
                    producto.precioUnitario=inputPU.val();
                  }
                  if (inputUds[0]){
                    producto.unidades=inputUds.val();
                  }
                  if (inputUtilidad[0]){
                    producto.utilidad=inputUtilidad.val();
                  }
                  if (inputPV[0]){
                    producto.precioVenta=inputPV.val();
                  }
                });
                data.push(producto);
              });
              $.ajax({
                  url: '../assets/php/Controllers/CInventario.php?method=abastecer',
                  type: 'POST',
                  data: {"data":data},
                  success:function(data){
                      if(data!=""){
                        if(data==1){
                          Swal({
                            title: 'Satisfactorio!',
                            text: "Se ha abastecido el inventario exitoxamente",
                            type: 'success',
                            confirmButtonColor: '#088A08',
                            confirmButtonText: 'Terminar'
                          }).then((result) => {
                            if (result.value) {
                              location.reload(true);
                            }
                          })
                        }else if(data==0){
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
    });

    function getDataEditProducto(tbody,table){
        $(tbody).on("click", ".editar-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            $("#nombre-producto").html(data.nombre);
            $("#input-id-producto-editar").val(data.id_producto);
            $("#input-nombre-producto-editar").val(data.nombre);
            $("#input-descripcion-producto-editar").val(data.descripcion);
            $("#input-referencia-fabrica-editar").val(data.referencia_fabrica);
            $('input:radio[name=IVA]:checked').val(data.tiene_iva);
            $("#input-codigo-barras-editar").val(data.codigo_barras);         
            $("#modal-editar-producto").modal("show");
        });
    }

    $("#cancelar-añadirProveedor").click(function(){
        document.getElementById("form-añadirProveedor").reset();
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
                        loadDataCompra(); 
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

    $("#form-editarProducto").submit(function(event){
        event.preventDefault();
        var data;
        data = {
            "idProducto" : $("#input-id-producto-editar").val(),
            "nombre" : $("#input-nombre-producto-editar").val(),
            "descripcion" : $("#input-descripcion-producto-editar").val(),
            "referenciaFabrica" : $("#input-referencia-fabrica-editar").val(),
            "utilidad" : $("#input-valor-utilidad-editar").val(),
            "iva" : $('input:radio[name=IVA-editar]:checked').val(),
            "CodigoDeBarras" : $("#input-codigo-barras-editar").val()
        } 
        $.ajax({
            url: '../assets/php/Controllers/CProducto.php?method=editarProducto',
            type: 'POST',
            data: data,
            success:function(data){
              if(data!=""){
                if(data==1){
                    $("#modal-editar-producto").modal("hide");
                    setTimeout(function(){
                        Swal(
                          'Satisfactorio!',
                          'Se ha editado correctamente el producto',
                          'success'
                          );
                        $("#nombre-producto").html("");
                        document.getElementById("form-editarProducto").reset();
                    },500); 
                }else if(data==0){
                    $("#modal-editar-producto").modal("hide");
                    setTimeout(function(){
                        Swal(
                          'Error!',
                          'Ha ocurrido un error, vuelva a intentar',
                          'error'
                          );
                        $("#nombre-producto").html("");
                        document.getElementById("form-editarProducto").reset();
                    },500);
                }else if(data==3){
                    $("#modal-editar-producto").modal("hide");
                    setTimeout(function(){
                        Swal(
                          'Error!',
                          'Opps, no se ha encontrado el proveedor para editar',
                          'error'
                          );
                    },500);
                }
            }
        }   
        }).always(function(){
            var idProveedor=$("#id-proveedor").val();
            loadDataProveedor(idProveedor);
            loadDataCompra();                         
        });

    });

    $("#input-nombre-producto").autocomplete({
        source: function(request,response){
          $("#input-id-producto").prop('disabled', false);
          $("#input-id-producto").val("");
          $("#input-descripcion-producto").val("");
          $("#input-referencia-fabrica").val("");
          $('input:radio[name=IVA]:checked').val(1);
          $("#input-codigo-barras").val(""); 
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

    $("#añadir-producto").click(function(){
      $("#input-id-producto").prop('disabled', false);
    });

    function buscarProductoAñadir(idProducto){
        $.ajax({
            url: '../assets/php/Controllers/CProducto.php?method=buscarProducto',
            type: 'POST',
            data: {"idProducto":idProducto},
            success:function(data){
                if(data!=""){
                    var producto=$.parseJSON(data);
                    $("#input-id-producto").prop('disabled', true);
                    $("#input-id-producto").val(producto.id_producto);
                    $("#input-descripcion-producto").val(producto.descripcion);
                    $("#input-referencia-fabrica").val(producto.referencia_fabrica);
                    $('input:radio[name=IVA]:checked').val(producto.tiene_iva);
                    $("#input-codigo-barras").val(producto.codigo_barras); 
                }  
            }
        });
    }




});


