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
    //RESET FORM INPUTS
    $("#form-terminar-venta")[0].reset();
    $("#input-descuento").prop('disabled', true);
    $("#input-retefuente").prop('checked', false);
    //RESET HTML INFO
    $("#subtotal-venta").html(0);
    $("#subtotal-venta").removeAttr("subtotal-venta");
    $("#iva-venta").html(0);
    $("#iva-venta").removeAttr("iva-venta");
    $("#total-venta").html(0);
    $("#total-venta").removeAttr("modificar-total-venta");
    $("#total-venta").attr("total-venta-no-modificada",0);
    $("#input-total-venta-modificada").val("");
    $("#descuento-venta").html("");
    $("#valor-descuento").fadeOut(0);
    $("#input-descuento").removeAttr("modificar-descuento");
    $("#input-retefuente").removeAttr("modificar-retefuente");
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
                            //RESET FORM INPUTS
                            $("#form-terminar-venta")[0].reset();
                            $("#input-descuento").prop('disabled', true);
                            $("#input-retefuente").prop('checked', false);
                            $("#input-descuento").removeAttr("modificar-descuento");
                            $("#input-retefuente").removeAttr("modificar-retefuente");
                            //LLENAR DATOS
                            $("#subtotal-venta").html(numberWithCommas(data.subtotalVenta));
                            $("#subtotal-venta").attr("subtotal-venta",data.subtotalVenta);
                            $("#input-subtotal-venta").val(data.subtotalVenta);
                            var iva=(data.totalVenta-data.subtotalVenta);
                            $("#iva-venta").html(numberWithCommas(iva));
                            $("#iva-venta").attr("iva-venta",iva);
                            $("#input-iva-venta").val(iva);
                            $("#total-venta").html(numberWithCommas(data.totalVenta));
                            $("#total-venta").removeAttr("modificar-total-venta");
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
        if(!$("#input-total-venta-producto").attr("modificar-total-producto")){
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
      var descuentos=new Object();
      var totalVentaNoModificada=parseInt($(input).attr("total-venta-no-modificada"));
      var totalVenta=parseInt($("#input-total-venta").val());
      totalVenta=totalVenta;
      var descuento=totalVentaNoModificada-totalVenta;
      descuentos.descuento=descuento;
      var descuentoPorcentual=1-(totalVenta/totalVentaNoModificada);
      descuentos.descuentoPorcentual=descuentoPorcentual;
      return descuentos;
    }

    $('#total-venta').bind("change keyup", function(e) {
        if($("#total-venta").attr("modificar-total-venta")){
            var descuentos=calcularDescuento('#total-venta');
            var descuento=descuentos.descuento;
            var descuentoPorcentual=descuentos.descuentoPorcentual*100;
            if(descuento>0 || descuento<0){
              $("#descuento-venta").html(numberWithCommas(descuento));
              $("#input-descuento-venta").val(descuento);
              $("#valor-descuento").fadeIn(50);
              $("#input-descuento").val(descuentoPorcentual);
              var retefuente=$("#input-retefuente-venta").val();
              retefuente=(retefuente=="")?0:parseFloat(retefuente);
              var subtotal=$("#subtotal-venta").attr("subtotal-venta");
              subtotal=(subtotal=="")?0:parseInt(subtotal);
              var iva=$("#iva-venta").attr("iva-venta");
              iva=(iva=="")?0:parseFloat(iva);
              calcularSubtotal(subtotal,descuentoPorcentual,retefuente);
              calcularIva(iva,descuentoPorcentual);
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
                      $("#total-venta").removeAttr("modificar-total-venta");
                      var subtotal=$("#subtotal-venta").attr("subtotal-venta");
                      subtotal=(subtotal=="")?0:parseInt(subtotal);
                      var iva=$("#iva-venta").attr("iva-venta");
                      iva=(iva=="")?0:parseFloat(iva);
                      calcularSubtotal(subtotal,0,0);
                      calcularIva(iva,0);
                      $("#input-descuento").val("");
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

    function calcularSubtotal(subtotal,descuento,retefuente){
      var subtotalNuevo=Math.floor((subtotal*(1-descuento/100)*(1-retefuente/100)));
      var retefuenteValor=Math.floor((subtotal*(1-descuento/100)*(retefuente/100)));
      if(!(Number.isNaN(subtotalNuevo))){
        $("#subtotal-venta").html(numberWithCommas(subtotalNuevo));
        $("#input-subtotal-venta").val(subtotalNuevo);
        $("#input-valor-retefuente-venta").val(retefuenteValor);
      }
      return subtotalNuevo;
    }

    function calcularIva(iva,descuento){
      var ivaNuevo=Math.ceil((iva*(1-descuento/100)));
      if(!(Number.isNaN(ivaNuevo))){
        $("#iva-venta").html(numberWithCommas(ivaNuevo));
        $("#input-iva-venta").val(ivaNuevo);
      }
      return ivaNuevo;
    }

    function calcularTotalVenta(calcularDescuento=false,retornar=false){
      var retefuente=$("#input-retefuente-venta").val();
      retefuente=(retefuente=="")?0:parseFloat(retefuente);
      var descuentoPorcentual=$("#input-descuento").val();
      descuentoPorcentual=(descuentoPorcentual=="")?0:parseFloat(descuentoPorcentual);
      var subtotal=$("#subtotal-venta").attr("subtotal-venta");
      subtotal=(subtotal=="")?0:parseInt(subtotal);
      var iva=$("#iva-venta").attr("iva-venta");
      iva=(iva=="")?0:parseFloat(iva);
      
      var nuevoSubtotal=calcularSubtotal(subtotal,descuentoPorcentual,retefuente);
      var nuevoIva=calcularIva(iva,descuentoPorcentual);
      var totalVenta=parseInt(nuevoSubtotal)+parseInt(nuevoIva);

      if(!retornar && !(Number.isNaN(totalVenta))){
        if(calcularDescuento){
          var totalVentaNoModificada=parseInt($('#total-venta').attr("total-venta-no-modificada"));
          var descuento=totalVentaNoModificada-totalVenta;
          $("#descuento-venta").html(numberWithCommas(descuento));
          $("#input-descuento-venta").val(descuento);
          $("#valor-descuento").fadeIn(50);
        }

        $("#total-venta").html(numberWithCommas(totalVenta));
        $("#input-total-venta-modificada").val(totalVenta);
        $("#total-venta").removeAttr("modificar-total-venta");
      }else{
        return totalVenta;
      }
      
    }

    $('#total-venta').bind("keyup", function(e) {
      if(e.keyCode==13){
        calcularTotalVenta();
      }
    });

   $(document).on("click", "#total-venta-producto , #total-venta", function(){
      var attr = $(this).attr('name'); 
      if (typeof attr !== typeof undefined && attr !== false) {
        if((!$("#input-total-venta-producto").attr("modificar-total-producto") && attr=="total-venta-producto") || (!$("#total-venta").attr("modificar-total-venta") && attr=="total-venta")){
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
                                $("#input-total-venta-producto").attr("modificar-total-producto","si");
                                $("#input-total-venta-producto").focus();
                              }else if(attr=="total-venta"){
                                if($("#input-retefuente").prop('checked')){
                                  setTimeout(function(){
                                    $("#input-retefuente").prop('checked', false);
                                  },50); 
                                  $("#input-retefuente").removeAttr("modificar-retefuente");
                                  $("#input-retefuente-venta").val("");
                                }
                                var total=calcularTotalVenta(false,true);                              
                                var inputTotal='<input type="number" class="form-control mb mr" id="input-total-venta" placeholder="Total" autocomplete="off" value="'+parseInt(total)+'">';
                                $("#total-venta").html(inputTotal);
                                $("#total-venta").attr("modificar-total-venta","si");
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
        if($("#input-total-venta-producto").attr("modificar-total-producto")){
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
      if((!$("#input-descuento").attr("modificar-descuento") && attr=="descuento") || (!$("#input-retefuente").attr("modificar-retefuente") && attr=="retefuente")){
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
                              $("#input-descuento").attr("modificar-descuento","si");
                              $("#input-descuento").focus();
                            }else if(attr=="retefuente"){
                              $("#input-retefuente").prop('checked', true);
                              var retefuente=$("#input-valor-retefuente").val();
                              $("#input-retefuente-venta").val(retefuente);
                              $("#input-retefuente").attr("modificar-retefuente","si");
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
        $("#input-retefuente").removeAttr("modificar-retefuente");
        $("#input-retefuente-venta").val("");
        calcularTotalVenta();
      }
    }
   });

   $('#input-descuento').bind("change keyup", function(e) {
        if($("#input-descuento").attr("modificar-descuento")){
            var descuento=parseInt($('#input-descuento').val());
            if(descuento!=0 && descuento!=3 && descuento!=5){
              $('#input-descuento').val("");
              $("#descuento-venta").html("");
              $("#input-descuento-venta").val("");
              $("#valor-descuento").fadeOut(0);
              calcularTotalVenta();
            }else if(Number.isNaN(descuento)){
              $("#descuento-venta").html("");
              $("#input-descuento-venta").val("");
              $("#valor-descuento").fadeOut(0);
              calcularTotalVenta();
            }else{
              calcularTotalVenta(true);
            }
        }
    });

   $('#input-efectivo').bind("change keyup", function(e) {
        var efectivo=parseInt($(this).val());
        if(efectivo>0){
          $("#identificacion-usuario-venta").fadeIn(50);
        }else{
          $(this).val("");
          $("#input-identificacion-usuario-venta").val("");
          $("#identificacion-usuario-venta").fadeOut(0);
        }

    });

   $("#terminar-venta").click(function(event){
    event.preventDefault();
    if(calcularTotalVenta(false,true)>0 && $("#body-table-venta tr").length>0){
      $("#form-terminar-venta").submit();
    }
   });

   function terminarVentaContadoUsuario(nombre,idCliente,iva,subtotal,descuento,retefuente,totalVenta,efectivo){
    swal({
      title: 'Terminar Venta!',
      html: "<p>Esta seguro de desear terminar la venta</p><p> CLIENTE: <strong>"+nombre+"</strong></p>",
      showCancelButton: true,
      confirmButtonColor: '#22C13C',
      cancelButtonColor: '#9A9A9A',
      confirmButtonText: 'Terminar!',
      cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
           var resolucion=$("#input-resolucion").val();
           var tipoVenta="Efectivo";
           var data={
                'idCliente':idCliente,
                'resolucion':resolucion,
                'iva':iva,
                'subtotal':subtotal,
                'descuento':descuento,
                'retefuente':retefuente,
                'tipoVenta':tipoVenta
            }
           $.ajax({
               url: '../assets/php/Controllers/CVenta.php?method=terminarVenta',
               type: 'POST',
               data: data,
               success:function(data){
                   if(data!=""){
                     if(data==1){
                       $("#value-cambio").html((efectivo-totalVenta));
                       $("#modal-cambio").modal("show");
                       loadData();
                       getVenta();
                     }else if(data==0){
                       Swal(
                         'Error!',
                         'Ha ocurrido un error, revisa y vuelve a intentar!',
                         'error'
                       );
                     }else if(data==3){
                       Swal(
                         'Error!',
                         'El cliente no se encuentra registrado!',
                         'error'
                       );
                     }else{
                       console.log(data);
                     }
                   }
               }
           });
        }
    });
   }
   $(document).on("change keyup", "#input-plazo", function(e){
    var plazo=parseInt($(this).val());
    if(plazo<=0){
      $(this).val("");
    }
  });

  $("#form-terminar-venta").submit(function(event){
    event.preventDefault();
    var efectivo=$("#input-efectivo").val();
    efectivo=(efectivo=="")?0:parseInt(efectivo);
    var iva=$("#input-iva-venta").val();
    iva=(iva=="")?0:parseInt(iva);
    var subtotal=$("#input-subtotal-venta").val();
    subtotal=(subtotal=="")?0:parseInt(subtotal);
    var descuento=$("#input-descuento-venta").val();
    descuento=(descuento=="")?0:parseInt(descuento);
    var retefuente=$("#input-valor-retefuente-venta").val();
    retefuente=(retefuente=="")?0:parseInt(retefuente);
    if(efectivo==0){
      var input='<div class="form-group">'+
                            '<center><p>Se iniciara un credito, ingrese el numero de identificacion del cliente. En caso de no ser un credito presione cancelar e ingrese el efectivo</p></center>'+
                        '</div>'+
                        '<div class="form-row">' + 
                          '<div class="form-group col-md-6">'+
                              '<input type="text" class="form-control" id="input-identificacion-usuario" placeholder="Numero de identificacion" required autocomplete="off">'+
                          '</div>'+
                          '<div class="form-group col-md-6">'+
                              '<a role="button" href="#" id="añadir-cliente" class="btn btn-primary">Registrar cliente<span class="btn-label btn-label-right"><i class="fa fa-user-plus"></i></span></a>'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario Administracion" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="password" class="form-control" id="input-password" placeholder="Contraseña Administracion" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="number" class="form-control" id="input-plazo" placeholder="plazo en dias (30 dias)" autocomplete="off">'+
                        '</div>';

      Swal({
        title:'Iniciar Credito',
        html: input,
        type: 'warning',
        showCancelButton: true, 
        cancelButtonText: "Calcelar",
        confirmButtonText: 'Continuar!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value) {
          var idUsuario=$("#input-identificacion-usuario").val();
          if(idUsuario==""){
            Swal(
              'Error!',
              'Ingresa un numero de identificacion para continuar!',
              'error'
            );
          }else{
            var dataAdministracion={
                'usuario':$("#input-usuario").val(),
                'password':$("#input-password").val()
            }
            
            $.ajax({
                url: '../assets/php/Controllers/CAdministracion.php?method=comprobarAdministrador',
                type: 'POST',
                data: dataAdministracion,
                success:function(data){
                    if(data==1){
                      var resolucion=$("#input-resolucion").val();
                      var tipoVenta="Credito";
                      var plazo=$("#input-plazo");
                      plazo=(plazo=="")?30:parseInt(plazo);
                      var data={
                          'idCliente':idUsuario,
                          'resolucion':resolucion,
                          'iva':iva,
                          'subtotal':subtotal,
                          'descuento':descuento,
                          'retefuente':retefuente,
                          'tipoVenta':tipoVenta,
                          'plazo':plazo
                      }
                      $.ajax({
                          url: '../assets/php/Controllers/CVenta.php?method=terminarVenta',
                          type: 'POST',
                          data: data,
                          success:function(data){
                              if(data!=""){
                                if(data==1){
                                  Swal(
                                    'Completado!',
                                    'Se ha registrado satisfactoriamente la venta a credito,!',
                                    'success'
                                  );
                                  loadData();
                                  getVenta();
                                }else if(data==0){
                                  Swal(
                                    'Error!',
                                    'Ha ocurrido un error, revisa y vuelve a intentar!',
                                    'error'
                                  );
                                }else if(data==3){
                                  Swal(
                                    'Error!',
                                    'El cliente no se encuentra registrado!',
                                    'error'
                                  );
                                }else{
                                  console.log(data);
                                }
                              }
                          }
                      });
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
        }
      });
    }else{
      var totalVenta=calcularTotalVenta(false,true);
      if(efectivo>=totalVenta){
        var idCliente=$("#input-identificacion-usuario-venta").val();
        idCliente=(idCliente!="")?idCliente:1;
        $.ajax({
            url: '../assets/php/Controllers/CCliente.php?method=buscarCliente',
            type: 'POST',
            data: {"id":idCliente},
            success:function(data){
              if(data!=3){
                data=$.parseJSON(data);
                if(data.response==1){
                  var nombre="";
                  if(idCliente==1){
                    nombre="Ferretruper";
                  }else{
                    nombre=data.nombre;
                  }
                  terminarVentaContadoUsuario(nombre,idCliente,iva,subtotal,descuento,retefuente,totalVenta,efectivo);
                }
              }else{
                Swal({
                  title: 'Registrar?',
                  html: "<p>No se ha encontrado el usuario con identificacion: <strong>"+idCliente+"</strong> Desea registrarlo?</p>",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, registrar!',
                  cancelButtonText: "Cancelar"
                }).then((result) => {
                  if (result.value) {
                    $("#input-id-cliente").val(idCliente);
                    $("#añadirCliente").modal("show");
                  }
                });
              }
            }
          });
      }else{
        Swal(
          'Error!',
          'Se debe ingresar el efectivo correcto para pagar',
          'error'
        );
      }
    }
  });

  $(document).on("click", "#añadir-cliente", function(event){
    event.preventDefault();
    var dataAdministracion={
        'usuario':$("#input-usuario").val(),
        'password':$("#input-password").val()
    }
    $.ajax({
        url: '../assets/php/Controllers/CAdministracion.php?method=comprobarAdministrador',
        type: 'POST',
        data: dataAdministracion,
        success:function(data){
            if(data==1){
              swal.close();
              $("#añadirCliente").modal("show");
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
  });
    
});

