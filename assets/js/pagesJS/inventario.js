$(document).ready(function() {

	$(window).load(function(){
   loadData(false);
   $("#ver-papelera").fadeIn(0);
 });

  $("#ver-papelera").click(function(event){
    event.preventDefault();
    $(this).fadeOut(0);
    loadData(true);
    $("#volver-principal").fadeIn(0);
  });

  $("#volver-principal").click(function(event){
    event.preventDefault();
    $(this).fadeOut(0);
    loadData(false);
    $("#ver-papelera").fadeIn(0);
  });
  function agregarUnidadesEmergentes(tbody,table){
    $(tbody).on("click", ".adicionar-producto", function(){
      var tabla=table.row($(this).parents("tr")).data();
      var input='<div class="form-group">'+
                      '<input type="text" class="form-control" id="input-unidades" placeholder="Unidades para agregar al producto" required autocomplete="off">'+
                  '</div>';
      swal({
        title: 'Agregar unidades a '+tabla[2],
        html: input,
        showCancelButton: true,
        confirmButtonColor: '#FFE000',
        cancelButtonColor: '#FF0000',
        confirmButtonText: 'Agregar!',
        cancelButtonText: "Cancelar"
      }).then((result) => {
          if (result.value) {
              var data={
                  'idProducto':tabla[1],
                  'unidades':$("#input-unidades").val()
              }
              $.ajax({
                  url: '../assets/php/Controllers/CInventario.php?method=agregarUnidadesEmergentes',
                  type: 'POST',
                  data: data,
                  success:function(data){
                      if(data==1){
                        setTimeout(function(){
                          Swal(
                            'Satisfactorio!',
                            'Se han agregado unidades emergentes al producto',
                            'success'
                            );
                        },100); 

                      }else if(data==0){
                          setTimeout(function(){
                              Swal(
                                'Error!',
                                'Ha ocurrido un error inesperado.',
                                'error'
                              );
                          },100);  
                      }
                  }
              });
          }
      });
    });
  }
  function loadData(papelera){
    if(!papelera){
      window.table=$('#table-productos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "../assets/php/Controllers/CProducto.php?method=verProductosInventario",
        "columnDefs": [ {"render": function (data, type, row) {
          return "";
        },
        className: "details-control",
        "targets": [0]} ],
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
      desactivarProducto("#table-productos tbody",table);
      agregarUnidadesEmergentes("#table-productos tbody",table);
    }else{
      window.table=$('#table-productos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "../assets/php/Controllers/CProducto.php?method=verProductosDeshabilitados",
        "columnDefs": [ {"render": function (data, type, row) {
          return "";
        },
        className: "details-control",
        "targets": [0]} ],
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
      reactivarProducto("#table-productos tbody",table);
    }
  }

  function desactivarProducto(tbody,table){
    $(tbody).on("click", ".eliminar-producto", function(){
      var data=table.row($(this).parents("tr")).data();
      Swal({
        title: 'Estas seguro?',
        text: "Se eliminara el producto "+data[2]+"!",
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
            data: {"idProducto":data[1]},
            success:function(data){  
              if(data!=""){
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
    });
  }
  function reactivarProducto(tbody,table){
    $(tbody).on("click", ".rehabilitar-producto", function(){
      var data=table.row($(this).parents("tr")).data();
      $.ajax({
        url: '../assets/php/Controllers/CProducto.php?method=reactivarProducto',
        type: 'POST',
        data: {"idProducto":data[1]},
        success:function(data){  
          if(data!=""){
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

  $('#table-productos tbody').on('click', 'td.details-control', function () {
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
        data: {"idProducto":row.data()[1]},
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