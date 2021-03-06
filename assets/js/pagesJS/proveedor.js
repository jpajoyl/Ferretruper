$(document).ready(function() {
    $(window).load(function(){
        var p = obtenerValorParametro("p");
        if(p==null){
            try{
                loadData();
            }catch(err){
                console.log(err);
            }
        }
    });


    function obtenerValorParametro(sParametroNombre) {
        var sPaginaURL = window.location.search.substring(1);
        var sURLVariables = sPaginaURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParametro = sURLVariables[i].split('=');
            if (sParametro[0] == sParametroNombre) {
              return sParametro[1];
          }
      }
      return null;
  }

  function formatData (data) {
    return '<div class="row">'+
    '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
    '<i><i class="fa fa-mobile"></i><strong>  Cel: </strong>'+data[9]+'</i>'+
    '</div>'+
    '</div>'+
    '<div class="row">'+
    '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
    '<i><i class="fa fa-phone"></i><strong> Tel: </strong>'+data[7]+'</i>'+
    '</div>'+
    '</div>';
}

function loadData(){
    window.table=$('#table-proveedores').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":"../assets/php/Controllers/CProveedor.php?method=verProveedores",
        "autoWidth": false,
        "columnDefs": [ { className: "table-proveedores-nit-proveedor", "targets": [ 1 ] },
                        {"render": function (data, type, row) {
                        return "";
                    },
                    className: "details-control",
                    "targets": [0]} ],
        "destroy":true,
        "responsive":true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se han encontrado registros",
            "info": "(_MAX_ proveedores) Pagina _PAGE_ de _PAGES_",
            "search": "Buscar",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": ""
        }
    });
    viewProveedor("#table-proveedores tbody",table);
    getDataEdit("#table-proveedores tbody",table);
    desactivarProveedor("#table-proveedores tbody",table);
}

$('#table-proveedores tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        row.child( formatData(row.data()) ).show();
        tr.addClass('shown');
    }
});

function viewProveedor(tbody,table){
    $(tbody).on("click", ".table-proveedores-nit-proveedor", function(){
        var data=table.row($(this).parents("tr")).data();
        window.location.href = "proveedores.php?p=verProveedor&id="+data[0];
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

function loadDataProveedor(){
    var idProveedor=$("#card-verProveedor").attr("id-proveedor");
    window.tableProductos=$('#table-productos-proveedor').DataTable({
        "ajax":{
            "method":"POST",
            "data": {
                "idProveedor": idProveedor
            },
            "url":"../assets/php/Controllers/CProveedor.php?method=productosProveedor",
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
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": ''
        },
        {"data":"id_producto"},
        {"data":"codigo_barras"},
        {"data":"nombre"},
        {"data":"referencia_fabrica"},
        {"data":"clasificacion_tributaria"},
        {"data":"valor_utilidad"},
        {"defaultContent":"<center><button class='btn btn-primary btn-xs editar-producto'><i class='fa fa-pencil'></i></button>\
        </button><button class='btn btn-danger btn-xs eliminar-producto'><i class='fa fa-trash-o'></i></button></center>"}
        ],
        "destroy":true,
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
    getDataEditProducto("#table-productos-proveedor tbody",tableProductos);
    desactivarProducto("#table-productos-proveedor tbody",tableProductos);
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

function getDataEdit(tbody,table){
    $(tbody).on("click", ".editar-proveedor", function(){
        var data=table.row($(this).parents("tr")).data();
        $("#nit-proveedor").html(data[1]);
        $("#digitoDeVerificacion").html(data[2]);
        $("#input-nit-editar").val(data[1]);
        $("#input-digito-de-verificacion-editar").val(data[2]);
        $("#input-nombre-editar").val(data[3]);
        $("#input-direccion-editar").val(data[5]);
        $("#input-ciudad-editar").val(data[6]);
        $("#input-email-editar").val(data[4]);
        $("#input-telefono-editar").val(data[7]);
        $("#input-celular-editar").val(data[9]);
        $("#input-clasificacion-editar").val(data[10]);           
        $("#modal-editar-proveedor").modal("show");
    });
}

function desactivarProveedor(tbody,table){
    $(tbody).on("click", ".eliminar-proveedor", function(){
        var data=table.row($(this).parents("tr")).data();
        Swal({
          title: 'Estas seguro?',
          text: "Se eliminara el proveedor "+data[3]+"!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminarlo!',
          cancelButtonText: "Cancelar"
      }).then((result) => {
          if (result.value) {
            $.ajax({
                url: '../assets/php/Controllers/CProveedor.php?method=desactivarProveedor',
                type: 'POST',
                data: {"nit":data[1]},
                success:function(data){  
                  if(data!=""){
                    if(data==1){
                        loadData();
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha eliminado correctamente el proveedor',
                              'success'
                              );
                        },500); 

                    }else if(data==0 || data==3){
                        loadData();  
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
  });
}

$("#cancelar-editarProveedor").click(function(){
    $("#nit-proveedor").html("");
    $("#digitoDeVerificacion").html("");
    document.getElementById("form-editarProveedor").reset();
});

$("#form-añadirProveedor").submit(function(event){
    event.preventDefault();
    var data;
    data = {
        "nit" : $("#input-nit").val(),
        "digitoDeVerificacion" : $("#input-digito-de-verificacion").val(),
        "nombre" : $("#input-nombre").val(),
        "direccion" : $("#input-direccion").val(),
        "ciudad" : $("#input-ciudad").val(),
        "email" : $("#input-email").val(),
        "telefono" : $("#input-telefono").val(),
        "celular" : $("#input-celular").val(),
        "clasificacion" : $("#input-clasificacion").val()
    }
    $.ajax({
        url: '../assets/php/Controllers/CProveedor.php?method=registrarProveedor',
        type: 'POST',
        data: data,
        success:function(data){  
          if(data!=""){
            if(data==1){
                $("#añadirProveedor").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Satisfactorio!',
                      'Se ha registrado correctamente el proveedor',
                      'success'
                      );
                    document.getElementById("form-añadirProveedor").reset();
                    loadData(); 
                },500); 
            }else if(data==0){
                $("#añadirProveedor").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'Ha ocurrido un error, vuelva a intentar',
                      'error'
                      );
                    document.getElementById("form-añadirProveedor").reset();
                    loadData();  
                },500);
            }else if(data==2){
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'Al parecer este numero de nit ya esta registrado',
                      'error'
                      );
                },500);
            }
        }
    }   
});

});

$("#form-editarProveedor").submit(function(event){
    event.preventDefault();
    var data;
    data = {
        "nit" : $("#input-nit-editar").val(),
        "digitoDeVerificacion" : $("#input-digito-de-verificacion-editar").val(),
        "nombre" : $("#input-nombre-editar").val(),
        "direccion" : $("#input-direccion-editar").val(),
        "ciudad" : $("#input-ciudad-editar").val(),
        "email" : $("#input-email-editar").val(),
        "telefono" : $("#input-telefono-editar").val(),
        "celular" : $("#input-celular-editar").val(),
        "clasificacion" : $("#input-clasificacion-editar").val()
    }
    $.ajax({
        url: '../assets/php/Controllers/CProveedor.php?method=editarProveedor',
        type: 'POST',
        data: data,
        success:function(data){ 
          if(data!=""){
            if(data==1){
                $("#modal-editar-proveedor").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Satisfactorio!',
                      'Se ha editado correctamente el proveedor',
                      'success'
                      );
                    $("#nit-proveedor").html("");
                    $("#digitoDeVerificacion").html("");
                    document.getElementById("form-editarProveedor").reset();
                },500); 
            }else if(data==0){
                $("#modal-editar-proveedor").modal("hide");
                setTimeout(function(){
                    Swal(
                      'Error!',
                      'Ha ocurrido un error, vuelva a intentar',
                      'error'
                      );
                    $("#nit-proveedor").html("");
                    $("#digitoDeVerificacion").html("");
                    document.getElementById("form-editarProveedor").reset();
                },500);
            }else if(data==3){
                $("#modal-editar-proveedor").modal("hide");
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
    loadData();                        
});

});

$("#cancelar-añadirProveedor").click(function(){
    document.getElementById("form-añadirProveedor").reset();
});

$(".productos-suministrados").click(function(){
    setTimeout(function(){
        loadDataProveedor();
    },50);
});

$("#cancelar-añadirProveedor").click(function(){
    document.getElementById("form-añadirProveedor").reset();
});

$(".productos-suministrados").click(function(){
    setTimeout(function(){
        loadDataProveedor();
    },50);
});

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

$("#cancelar-añadirProveedor").click(function(){
    document.getElementById("form-añadirProveedor").reset();
});


$("#cancelar-añadirProveedor").click(function(){
    document.getElementById("form-añadirProveedor").reset();
});



function desactivarProducto(tbody,table){
    $(tbody).on("click", ".eliminar-producto", function(){
        var data=table.row($(this).parents("tr")).data();
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
                        loadDataProveedor();
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha eliminado correctamente el producto',
                              'success'
                              );
                        },500); 

                    }else if(data==0 || data==3){
                        loadDataProveedor();  
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
  });
}

$("#cancelar-editarProducto").click(function(){
    $("#nombre-producto").html("");
    document.getElementById("form-editarProducto").reset();
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
        loadDataProveedor();                        
    });

});

}); 

