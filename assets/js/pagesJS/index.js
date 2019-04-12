$(document).ready(function() {

	$(window).load(function(){
       loadData();
       getVenta();
   });

  function noVenta(){
    $("#table-venta > tbody").html("");
    var tbody='<td colspan="6" class="no-venta"><div class="alert alert-secondary mt" role="alert">'+
         'Aun no se ha iniciado una venta. Seleccione un producto para iniciar'+
         '</div></td>';
    $("#table-venta > tbody").prepend(tbody);
    $("#terminar-venta").fadeOut(0);
    $("#cancelar-venta").fadeOut(0);
    $(".no-venta").fadeIn(0);
    $("#subtotal-venta").html(0);
    $("#iva-venta").html(0);
    $("#total-venta").html(0);
    $("#total-venta").removeAttr("enviar-total-venta");
    $("#input-total-venta-modificada").val("");
    $("#descuento-venta").html("");
    $("#input-descuento-venta").val("");
    $("#valor-descuento").fadeOut(0);
    $("#input-descuento").prop('disabled', true);
    $("#input-descuento").removeAttr("enviar-descuento");
    $("#input-retefuente").prop('checked', false);
    $("#input-retefuente").removeAttr("enviar-retefuente");
    $("#input-retefuente-venta").val("");
  }

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
                            $("#terminar-venta").fadeIn(0);
                            $("#cancelar-venta").fadeIn(0);
                            $("#subtotal-venta").html(numberWithCommas(data.subtotalVenta));
                            $("#iva-venta").html(numberWithCommas((data.totalVenta-data.subtotalVenta)));
                            $("#total-venta").html(numberWithCommas(data.totalVenta));
                            $("#total-venta").removeAttr("enviar-total-venta");
                            $("#total-venta").attr("total-venta-no-modificada",data.totalVenta);
                            $("#descuento-venta").html("");
                            $("#input-descuento-venta").val("");
                            $("#valor-descuento").fadeOut(0);
                        }else{
                          noVenta();
                        }
                    }else{
                      noVenta();
                    }
                }else{
                    Swal(
                      'Error!',
                      'A ocurrido un error',
                      'error'
                    );
                }
            }
        });
	}

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

	function loadData(){
        window.table=$('#table-productos').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "../assets/php/Controllers/CProducto.php?method=verProductos",
          "createdRow":function (row, data, index){
            $(row).attr("id-producto-inventario",data[0]);
             if(parseInt(data[4]) == 0){
                  $(row).toggleClass('tr-warning');
              }
              if(parseInt(data[4]) < 0){
                  $(row).toggleClass('tr-locked');
            }
          },
          "columnDefs": [ { className: "unidades-totales", "targets": [ 4 ] } ],
          "destroy":true,
          "autoWidth": false,
          "responsive":true,
          "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se han encontrado registros",
            "info": "(_MAX_ productos) Pagina _PAGE_ de _PAGES_",
            "search": "Buscar",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": ""
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
                                data[0]+'<input type="hidden" id="input-id-producto" value="'+data[0]+'">'+
                            '</td>'+
                            '<td>'+
                                data[1]+
                            '</td>'+
                            '<td width="15%">'+
                                numberWithCommas(data[5])+'<input type="hidden" id="input-precio-inventario-producto" value="'+data[5].replace(/,/g, "")+'">'+
                            '</td>'+
                            '<td width="15%" id="td-cantidad-producto">'+
                                '<input type="number" class="form-control" id="input-cantidad-producto" placeholder="cantidad" autocomplete="off">'+
                            '</td>'+
                            '<td width="15%" id="total-venta-producto" name="total-venta-producto">'+
                                '<input type="text" class="form-control" id="input-total-venta-producto" placeholder="total producto" autocomplete="off" disabled>'+
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
        if(!$("#input-total-venta-producto").attr("enviar-total-producto")){
            var precio=parseInt($("#input-precio-inventario-producto").val());
            var cantidad=parseInt($("#input-cantidad-producto").val());
            var total=precio*cantidad;
            if(total>0){
                $("#input-total-venta-producto").val(numberWithCommas(total.toString()));
            }else{
                $("#input-cantidad-producto").val("");
                $("#input-total-venta-producto").val("");
            }
        }
    });

    function calcularDescuento(input){
      var totalVentaNoModificada=parseInt($(input).attr("total-venta-no-modificada"));
      var totalVenta=parseInt($("#input-total-venta").val());
      var descuento=totalVentaNoModificada-totalVenta;
      return descuento;
    }

    $('#total-venta').bind("change keyup", function(e) {
        if($("#total-venta").attr("enviar-total-venta")){
            descuento=calcularDescuento('#total-venta');
            if(descuento>0 || descuento<0){
              $("#descuento-venta").html(numberWithCommas(descuento));
              $("#input-descuento-venta").val(descuento);
              $("#valor-descuento").fadeIn(50);
            }else{
              if(descuento==0){
                $("#descuento-venta").html("");
                $("#input-descuento-venta").val("");
                $("#valor-descuento").fadeOut(0);
              }else{
                setTimeout(function(){
                  descuento=calcularDescuento('#total-venta');
                  if(!(descuento>0 || descuento<0)){
                    if(descuento!=0){
                      var totalVentaNoModificada=parseInt($('#total-venta').attr("total-venta-no-modificada"));
                      $("#total-venta").html(numberWithCommas(totalVentaNoModificada));
                      $("#total-venta").removeAttr("enviar-total-venta");
                    }
                    $("#descuento-venta").html("");
                    $("#input-descuento-venta").val("");
                    $("#valor-descuento").fadeOut(0);
                  }
                },1500);
              }
            }
        }
    });

    function calcularTotalVenta(){
      var totalVentaNoModificada=parseInt($('#total-venta').attr("total-venta-no-modificada"));
      var descuento=$("#input-descuento-venta").val();
      descuento=(descuento=="")?0:parseInt(descuento);
      var retefuente=$("#input-retefuente-venta").val();
      retefuente=(retefuente=="")?0:parseInt(retefuente);
      var plusDescuento=$("#input-descuento").val();
      plusDescuento=(plusDescuento=="")?0:parseInt(plusDescuento);
      var totalVenta=(totalVentaNoModificada-descuento)*(1-(plusDescuento)/100)*(1-(retefuente)/100);

      $("#total-venta").html(numberWithCommas(totalVenta));
      $("#input-total-venta-modificada").val(totalVenta);
      $("#total-venta").removeAttr("enviar-total-venta");
    }

    $('#total-venta').bind("keyup", function(e) {
      if(e.keyCode==13){
        calcularTotalVenta();
      }
    });

   $(document).on("click", "#total-venta-producto , #total-venta", function(){
      var attr = $(this).attr('name'); 
      if (typeof attr !== typeof undefined && attr !== false) {
        if((!$("#input-total-venta-producto").attr("enviar-total-producto") && attr=="total-venta-producto") || (!$("#total-venta").attr("enviar-total-venta") && attr=="total-venta")){
            var input='<div class="form-group">'+
                            '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="password" class="form-control" id="input-password" placeholder="Contraseña" required autocomplete="off">'+
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
                              if(attr=="total-venta-producto"){
                                $("#input-total-venta-producto").prop('disabled', false);
                                $("#input-total-venta-producto").attr("enviar-total-producto","si");
                                $("#input-total-venta-producto").focus();
                              }else if(attr=="total-venta"){
                                var total=$("#total-venta").text().replace(/,/g, "");
                                var inputTotal='<input type="number" class="form-control mb mr" id="input-total-venta" placeholder="Total" autocomplete="off" value="'+parseInt(total)+'">';
                                $("#total-venta").html(inputTotal);
                                $("#total-venta").attr("enviar-total-venta","si");
                              } 
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
        if($("#input-total-venta-producto").attr("enviar-total-producto")){
            try{
                var totalVenta=parseInt($("#input-total-venta-producto").val().replace(/,/g, ""));
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

   $("#cancelar-venta").click(function(event){
    event.preventDefault();
        if($("#body-table-venta tr").length>0){
          $.ajax({
              url: '../assets/php/Controllers/CVenta.php?method=cancelarVenta',
              type: 'POST',
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
        }
   });

   $(document).on("click", "#descuento , #input-retefuente", function(event){
    event.preventDefault();
    var attr = $(this).attr('name'); 
    if (typeof attr !== typeof undefined && attr !== false) {
      if((!$("#input-descuento").attr("enviar-descuento") && attr=="descuento") || (!$("#input-retefuente").attr("enviar-retefuente") && attr=="retefuente")){
        var input="";
        if(attr=="descuento"){
          input=input+'<div class="form-group">'+
                                '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario" required autocomplete="off">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<input type="password" class="form-control" id="input-password" placeholder="Contraseña" required autocomplete="off">'+
                            '</div>';
        }else if(attr=="retefuente"){
          input=input+'<div class="form-group">'+
                                '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario" required autocomplete="off">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<input type="password" class="form-control" id="input-password" placeholder="Contraseña" required autocomplete="off">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<input type="number" class="form-control" id="input-valor-retefuente" placeholder="% retefuente" required autocomplete="off">'+
                            '</div>';
        }
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
                            if(attr=="descuento"){
                              $("#input-descuento").prop('disabled', false);
                              $("#input-descuento").attr("enviar-descuento","si");
                              $("#input-descuento").focus();
                            }else if(attr=="retefuente"){
                              $("#input-retefuente").prop('checked', true);
                              var retefuente=$("#input-valor-retefuente").val();
                              $("#input-retefuente-venta").val(retefuente);
                              $("#input-retefuente").attr("enviar-retefuente","si");
                              calcularTotalVenta();
                            }
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
      if(!$("#input-retefuente").prop('checked')){
        setTimeout(function(){
          $("#input-retefuente").prop('checked', false);
        },50); 
        $("#input-retefuente").removeAttr("enviar-retefuente");
        $("#input-retefuente-venta").val("");
        calcularTotalVenta();
      }
    }
   });

   $('#input-descuento').bind("change keyup", function(e) {
        if($("#input-descuento").attr("enviar-descuento")){
            var descuento=parseInt($('#input-descuento').val());
            if(descuento!=0 && descuento!=3 && descuento!=5){
              $('#input-descuento').val("");
            }
        }
        calcularTotalVenta();
    });

   $("#terminar-venta").click(function(event){
    event.preventDefault();
        if($("#body-table-venta tr").length>0){
          $("#form-terminar-venta").submit();
        }
   });
    
});

