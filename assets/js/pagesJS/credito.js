$(document).ready(function() {

	$(window).load(function(){
	 	loadData(false);
        $("#ver-pagados").fadeIn(0);
	});

    $("#ver-pagados").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(true);
        $("#volver-principal").fadeIn(0);
    });

    $("#volver-principal").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(false);
        $("#ver-pagados").fadeIn(0);
    });

	function loadData(pagados){
        if(!pagados){
            window.table=$('#table-creditos').DataTable({
                "ajax":{
                    "method":"POST",
                    "url":"../assets/php/Controllers/CCredito.php?method=verCreditos",
                    "dataSrc": function(data){
                        if(data == 3){
                            return [];
                        }else {
                            return data.creditos;
                        }
                    }
                },
                "autoWidth": false,
                "columns":[
                {
                            "searchable": false,
                            "orderable": false,
                            "targets": 0,
                            "data":           null
                },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {"data":"VENTAS_id_venta"},
                {"data":"USUARIOS_id_cliente"},
                {"data":"total"},
                {"data":"fecha"},//FECHA
                {"data":"estado"},
                {"defaultContent":"<center><button class='btn btn-primary btn-xs editar-producto'><i class='fa fa-pencil'></i></button>\
                </button><button class='btn btn-danger btn-xs eliminar-producto'><i class='fa fa-trash-o'></i></button></center>"}
                ],
                "order": [[ 1, 'asc' ]],
                "destroy":true,
                "responsive":true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado registros",
                    "info": "(_MAX_ proveedores) Pagina _PAGE_ de _PAGES_",
                    "search": "Buscar",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(registros disponibles _MAX_)"
                }
            });

            table.on( 'order.dt search.dt', function () {
                    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();

            desactivarProducto("#table-creditos tbody",table);
        }else{
            window.table=$('#table-creditos').DataTable({
                "ajax":{
                    "method":"POST",
                    "url":"../assets/php/Controllers/CProducto.php?method=vercreditosDeshabilitados",
                    "dataSrc": function(data){
                        if(data == 3){
                            return [];
                        }else {
                            return data.creditos;
                        }
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
                {"data":"codigo_barras"},
                {"data":"unidades_totales"},
                {"data":"precio_mayor_inventario"},
                {"defaultContent":"<center><button class='btn btn-success btn-xs rehabilitar-producto'><i class='fa fa-chevron-circle-left'></i></center>"}
                ],
                "destroy":true,
                "responsive":true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado registros",
                    "info": "(_MAX_ proveedores) Pagina _PAGE_ de _PAGES_",
                    "search": "Buscar",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(registros disponibles _MAX_)"
                }
            });
            reactivarProducto("#table-creditos tbody",table);
        }
        getDataEditProducto("#table-creditos tbody",table);
    }

    function getDataEditProducto(tbody,table){
        $(tbody).on("click", ".editar-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            $("#nombre-producto").html(data.nombre);
            $("#input-id-producto-editar").val(data.id_producto);
            $("#input-nombre-producto-editar").val(data.nombre);
            $("#input-descripcion-producto-editar").val(data.descripcion);
            $("#input-referencia-fabrica-editar").val(data.referencia_fabrica);
            $("#input-valor-utilidad-editar").val(data.valor_utilidad);
            $('input:radio[name=IVA]:checked').val(data.tiene_iva);
            $("#input-codigo-barras-editar").val(data.codigo_barras);         
            $("#modal-editar-producto").modal("show");
        });
    }

    function desactivarProducto(tbody,table){
        $(tbody).on("click", ".eliminar-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            if(parseInt(data.unidades_totales)>0){
                    Swal({
                      title: 'Estas seguro?',
                      text: "Se eliminara el producto "+data.nombre+"!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Si, Eliminarlo!',
                      cancelButtonText: "Cancelar"
                  }).then((result) => {
                      if (result.value) {
                        $.ajax({
                            url: '../assets/php/Controllers/CProducto.php?method=desactivarProducto',
                            type: 'POST',
                            data: {"idProducto":data.id_producto},
                            success:function(data){  
                              if(data!=""){
                                console.log(data);
                                if(data==1){
                                    loadData(false);
                                    setTimeout(function(){
                                        Swal(
                                          'Satisfactorio!',
                                          'Se ha eliminado correctamente el producto',
                                          'success'
                                          );
                                    },500); 

                                }else if(data==0 || data==3){
                                    loadData(false); 
                                    setTimeout(function(){
                                        Swal(
                                          'Error!',
                                          'Ha ocurrido un error, vuelva a intentar',
                                          'error'
                                          );
                                    },500);        
                                }
                            }
                        }   
                    });
                    }
                });
            }else{
                Swal(
                  'Error!',
                  'No se puede eliminar el producto',
                  'error'
                  );
            }       
        });
    }
    function reactivarProducto(tbody,table){
        $(tbody).on("click", ".rehabilitar-producto", function(){
            var data=table.row($(this).parents("tr")).data();
                $.ajax({
                    url: '../assets/php/Controllers/CProducto.php?method=reactivarProducto',
                    type: 'POST',
                    data: {"idProducto":data.id_producto},
                    success:function(data){  
                      if(data!=""){
                        console.log(data);
                        if(data==1){
                            loadData(true);
                            setTimeout(function(){
                                Swal(
                                  'Satisfactorio!',
                                  'Se ha reactivado correctamente el producto',
                                  'success'
                                  );
                            },500); 

                        }else if(data==0 || data==3){
                            loadData(true); 
                            setTimeout(function(){
                                Swal({
                                  title: 'Error!',
                                  text: "Sugerimos recargar la pagina",
                                  type: 'error',
                                  confirmButtonColor: '#088A08',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Si, recargar!',
                                  cancelButtonText: "No"
                                }).then((result) => {
                                  if (result.value) {
                                    location.reload(true);
                                  }
                                })
                            },500);        
                        }
                    }
                }   
            });
        });
    }

    $('#table-creditos tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            $.ajax({
                url: '../assets/php/Controllers/CInventario.php?method=verInventarios',
                type: 'POST',
                data: {"idProducto":row.data().id_producto},
                success:function(data){
                    if(data!=""){
                        if(data!=3){
                            var contenido='<table id="table-inventarios-producto" class="table table-responsive-xl table-bordered">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th scope="col">NIT</th>'+
                                    '<th scope="col">Proveedor</th>'+
                                    '<th scope="col">Precio compra</th>'+
                                    '<th scope="col">Unidades</th>'+
                                    '<th scope="col">Precio inventario</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                            $.map($.parseJSON(data).inventarios, function(dataInventarios) {
                                contenido+='<tr>'+
                                        '<td class="nit-proveedor-inventario">'+dataInventarios.numero_identificacion+'-'+dataInventarios.digito_de_verificacion+'</td>'+
                                        '<td class="nombre-proveedor-inventario">'+dataInventarios.nombre+'</td>'+
                                        '<td class="precio-compra-inventario">'+dataInventarios.precio_compra+'</td>'+
                                        '<td class="unidades-inventario">'+dataInventarios.unidades+'</td>'+
                                        '<td class="precio-venta-inventario">'+dataInventarios.precio_inventario+'</td>'+
                                        '</tr>';
                            });
                            contenido+='</tbody></table>'
                            row.child(contenido).show();
                        }else{
                            var contenido='<div class="alert alert-danger" role="alert">Este producto no tiene ningun proveedor aun</div>';
                            row.child(contenido).show();
                        }
                        
                    }  
                }
            }).always(function(){
                tr.addClass('shown');
            });
        }
    });

    $("#form-editarProducto").submit(function(event){
        event.preventDefault();
        var data;
        data = {
            "idProducto" : $("#input-id-producto-editar").val(),
            "nombre" : $("#input-nombre-producto-editar").val(),
            "descripcion" : $("#input-descripcion-producto-editar").val(),
            "referenciaFabrica" : $("#input-referencia-fabrica-editar").val(),
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
            loadData(false);                        
        });

    });
});