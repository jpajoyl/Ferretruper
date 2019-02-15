$(document).ready(function() {

	$(window).load(function(){
       loadData();
       getVenta();
   });

	function getVenta(){
		$.ajax({
            url: '../assets/php/Controllers/CVenta.php?method=obtenerVenta',
            type: 'POST',
            success:function(data){
                if(data!=0){
                  data=$.parseJSON(data);
                    if(data.response==1){
                      $("#table-venta > tbody").html("");
                        if(data.productosxventa!=3){
                            $.map(data.productosxventa, function(producto) {
                             var tbody='<tr id-productosxventa="'+producto.id_productoxventa+'">'+
                               '<td width="15%" id="td-id-producto">'+producto.id_producto+'</td>'+
                               '<td>'+producto.nombre+'</td>'+
                               '<td width="15%">'+numberWithCommas(producto.precio_mayor_inventario)+'</td>'+
                               '<td width="15%">'+producto.unidades+'</td>'+
                               '<td width="15%">'+numberWithCommas(producto.precio_venta*producto.unidades)+'</td>'+
                               '<td width="15%"><center><button class="btn btn-danger btn-xs eliminar-producto-seleccionado"><i class="fa fa-trash"></i></button></button></center></td>'+
                               '</tr>';
                             $("#table-venta > tbody").prepend(tbody);
                            }); 
                        }else{
                          var tbody='<td colspan="6" class="no-venta"><div class="alert alert-secondary mt" role="alert">'+
                               'Aun no se ha iniciado una venta. Seleccione un producto para iniciar'+
                               '</div></td>';
                          $("#table-venta > tbody").prepend(tbody);
                          $(".no-venta").fadeIn(0);
                        }
                        $("#total-preCompra").html(numberWithCommas(data.totalVenta));
                    }
                }else{
                    $(".no-venta").fadeIn(0);
                }
            }
        });
	}

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

	function loadData(){
        window.table=$('#table-productos').DataTable({
            "ajax":{
                "method":"POST",
                "url":"../assets/php/Controllers/CProducto.php?method=verProductos",
                "dataSrc": function(data){
                    if(data == 3){
                        return [];
                    }else {
                        return data.productos;
                    }
                }
            },
            "destroy":true,
            "autoWidth": false,
            "columns":[
            {"data":"id_producto"},
            {"data":"nombre"},
            {"data":"referencia_fabrica"},
            {"data":"codigo_barras"},
            {className:"unidades-totales","data":"unidades_totales"},
            {"data":function (data, type, row){
                return numberWithCommas(data.precio_mayor_inventario);
            }},
            {className:"button-añadir-producto","data":function (data, type, row){
            	if(parseInt(data.unidades_totales)>0) {
            		return "<center><button class='btn btn-success btn-xs añadir-producto'><i class='fa fa-plus-circle'></i></button>\
                    </button></center>";
                }else{
                  return "";
              }
            }}
          ],
          "createdRow":function (row, data, index){
            $(row).attr("id-producto-inventario",data.id_producto);
             if(parseInt(data.unidades_totales) == 0){
                  $(row).toggleClass('tr-warning');
              }
              if(parseInt(data.unidades_totales) < 0){
                  $(row).toggleClass('tr-locked');
            }
          },
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
        añadirProducto("#table-productos tbody",table);
    }

    function añadirProducto(tbody,table){
        $(tbody).on("click", ".añadir-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            if(!$("#añadir-producto-venta").length){
                var tbody='<tr id="añadir-producto-venta">'+
                            '<td width="15%" id="td-id-producto">'+
                                data.id_producto+'<input type="hidden" id="input-id-producto" value="'+data.id_producto+'">'+
                            '</td>'+
                            '<td>'+
                                data.nombre+
                            '</td>'+
                            '<td width="15%">'+
                                numberWithCommas(data.precio_mayor_inventario)+'<input type="hidden" id="input-precio-inventario-producto" value="'+data.precio_mayor_inventario+'">'+
                            '</td>'+
                            '<td width="15%" id="td-cantidad-producto">'+
                                '<input type="number" class="form-control" id="input-cantidad-producto" placeholder="cantidad" autocomplete="off">'+
                            '</td>'+
                            '<td width="15%" id="total-venta-producto">'+
                                '<input type="text" class="form-control" id="input-total-venta" placeholder="total venta" autocomplete="off" disabled>'+
                            '</td>'+
                            '<td width="10%">'+
                                '<center><button class="btn btn-danger btn-xs eliminar-producto-no-seleccionado"><i class="fa fa-trash"></i></button></button></center>'+
                            '</td></tr>';
                $(".no-venta").fadeOut(0);
                $("#body-table-venta").prepend(tbody);
                setTimeout(function(){
                    $("#input-cantidad-producto").focus();
                },50);
            }else{
               setTimeout(function(){
                    $("#input-cantidad-producto").focus();
                },50); 
            }
        });
    }

    $(document).on("click", ".eliminar-producto-no-seleccionado", function(){
        $(this).closest('tr').remove();
        if($("#body-table-venta tr").length==0){
            $(".no-venta").fadeIn(0);
        }
    });

    $('#form-añadir-producto-venta').bind("keypress", function(e) {
      if (e.keyCode == 13) {             
        $("#form-añadir-producto-venta").submit();
        return false;
      }
    });

    $('#form-añadir-producto-venta').bind("change keyup", function(e) {
        if(!$("#input-total-venta").attr("enviar-total")){
            var precio=parseInt($("#input-precio-inventario-producto").val());
            var cantidad=parseInt($("#input-cantidad-producto").val());
            var total=precio*cantidad;
            if(total>0){
                $("#input-total-venta").val(numberWithCommas(total.toString()));
            }else{
                $("#input-cantidad-producto").val("");
                $("#input-total-venta").val("");
            }
        }
    });

   $(document).on("click", "#total-venta-producto", function(){
        if(!$("#input-total-venta").attr("enviar-total")){
            var input='<div class="form-group">'+
                            '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="text" class="form-control" id="input-password" placeholder="Contraseña" required autocomplete="off">'+
                        '</div>';
                        
            swal({
              title: 'Funcion bloqueada',
              html: input,
              showCancelButton: true,
              confirmButtonColor: '#22C13C',
              cancelButtonColor: '#9A9A9A',
              confirmButtonText: 'Comprobar!',
              cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    var data={
                        'usuario':$("#input-usuario").val(),
                        'password':$("#input-password").val()
                    }
                    $.ajax({
                        url: '../assets/php/Controllers/CAdministracion.php?method=comprobarAdministrador',
                        type: 'POST',
                        data: data,
                        success:function(data){
                            if(data==1){
                                $("#input-total-venta").prop('disabled', false);
                                $("#input-total-venta").attr("enviar-total","si");
                                $("#input-total-venta").focus();
                            }else if(data==0 || data==3){
                                setTimeout(function(){
                                    Swal(
                                      'Error!',
                                      'El usuario y/o contraseña son incorrectos',
                                      'error'
                                    );
                                },100);  
                            }
                        }
                    });
                }
            });
        }
    });

   $("#form-añadir-producto-venta").submit(function(event){
        event.preventDefault();
        var añadirProducto=true;
        var data = new Object();
        var idProducto=$("#input-id-producto").val();
        data.idProducto=idProducto;
        var cantidad=parseInt($("#input-cantidad-producto").val());
        if(!cantidad>0){
            añadirProducto=false;
        }
        data.unidades=cantidad;
        if($("#input-total-venta").attr("enviar-total")){
            try{
                var totalVenta=parseInt($("#input-total-venta").val().replace(/,/g, ""));
                if(totalVenta>0){
                    data.totalVenta=totalVenta;
                }else{
                    Swal(
                      'Error!',
                      'Tenemos un error, revisa!',
                      'error'
                    );
                    añadirProducto=false;
                }  
            }catch(err){
                Swal(
                  'Error!',
                  'Tenemos un error, revisa!',
                  'error'
                );
                añadirProducto=false;
            }  
        }
        if(añadirProducto){
            $.ajax({
                url: '../assets/php/Controllers/CVenta.php?method=seleccionarProducto',
                type: 'POST',
                data: data,
                success:function(data){
                    if(data==1){
                        var tr_unidades=$("#body-table-Productos tr[id-producto-inventario="+idProducto+"] .unidades-totales");
                        var unidadesTotales=parseInt(tr_unidades.text());
                        tr_unidades.html(unidadesTotales-cantidad);
                        if(unidadesTotales-cantidad==0){
                           $("#body-table-Productos tr[id-producto-inventario="+idProducto+"]").addClass("tr-warning");
                           $("#body-table-Productos tr[id-producto-inventario="+idProducto+"] .button-añadir-producto").html("");
                        }
                        setTimeout(function(){
                            getVenta();
                        },50);
                    }else{
                        Swal(
                          'Error!',
                          'Tenemos un error, recarga y vuelve a intentar!',
                          'error'
                        );
                    }
                }
            });
        }
   });

   $(document).on("click", ".eliminar-producto-seleccionado", function(){
        var idProductoXVenta=$(this).closest('tr').attr("id-productosxventa");
        if($("#body-table-venta tr").length==0){
            $(".no-venta").fadeIn(0);
        }
        $.ajax({
            url: '../assets/php/Controllers/CVenta.php?method=deseleccionarProducto',
            type: 'POST',
            data: {"idProductoXVenta":idProductoXVenta},
            success:function(data){
                if(data==1){
                 loadData();
                 getVenta();
                }else{
                    Swal(
                      'Error!',
                      'Tenemos un error, recarga y vuelve a intentar!',
                      'error'
                    );
                }
            }
        });
    });
    
});

