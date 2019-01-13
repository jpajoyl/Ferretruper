$(document).ready(function() {
    $(window).load(function(){
        loadData();
    });


    function formatData (data) {
        return '<div class="row">'+
                        '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
                            '<i><i class="fa fa-mobile"></i><strong>  Cel: </strong>'+data.celular+'</i>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'+
                            '<i><i class="fa fa-phone"></i><strong> Tel: </strong>'+data.telefono+'</i>'+
                        '</div>'+
                    '</div>';
    }

    function loadData(){
        window.table=$('#table-clientes').DataTable({
                "ajax":{
                    "method":"POST",
                    "url":"../assets/php/Controllers/CCliente.php?method=verClientes"
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
                    {"data":"numero_identificacion"},
                    {"data":"digito_de_verificacion"},
                    {"data":"nombre"},
                    {"data":"email"},
                    {"data":"direccion"},
                    {"data":"ciudad"},
                    {"data":"telefono"},
                    {"defaultContent":"<button class='btn btn-primary btn-xs editar-cliente'><i class='fa fa-pencil'></i></button>\
                    </button><button class='btn btn-danger btn-xs eliminar-cliente'><i class='fa fa-trash-o'></i></button>"}
                ],
                "destroy":true,
                "responsive":true,
                "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se han encontrado registros",
                "info": "(_MAX_ clientes) Pagina _PAGE_ de _PAGES_",
                "search": "Buscar",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(registros disponibles _MAX_)"
                }
            });
        getDataEdit("#table-clientes tbody",table);
        desactivarCliente("#table-clientes tbody",table);
    }

     $('#table-clientes tbody').on('click', 'td.details-control', function () {
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


    function getDataEdit(tbody,table){
        $(tbody).on("click", ".editar-cliente", function(){
            var data=table.row($(this).parents("tr")).data();
            $("#id-cliente").html(data.numero_identificacion);
            if(data.digito_de_verificacion!=""){
                $("#digitoDeVerificacion").html("-"+data.digito_de_verificacion);
            }
            $("#input-id-editar").val(data.numero_identificacion);
            $("#input-digito-de-verificacion-editar").val(data.digito_de_verificacion);
            $("#input-nombre-editar").val(data.nombre);
            $("#input-direccion-editar").val(data.direccion);
            $("#input-ciudad-editar").val(data.ciudad);
            $("#input-email-editar").val(data.email);
            $("#input-telefono-editar").val(data.telefono);
            $("#input-celular-editar").val(data.celular);
            $("#input-clasificacion-editar").val(data.clasificacion);           
            $("#modal-editar-cliente").modal("show");
        });
    }

    function desactivarCliente(tbody,table){
        $(tbody).on("click", ".eliminar-cliente", function(){
            var data=table.row($(this).parents("tr")).data();
            Swal({
              title: 'Estas seguro?',
              text: "Se eliminara el cliente "+data.nombre+"!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Eliminarlo!',
              cancelButtonText: "Cancelar"
            }).then((result) => {
              if (result.value) {
                $.ajax({
                    url: '../assets/php/Controllers/CCliente.php?method=desactivarCliente',
                    type: 'POST',
                    data: {"id":data.numero_identificacion},
                    success:function(data){  
                      if(data!=""){
                        if(data==1){
                            loadData();
                            setTimeout(function(){
                                Swal(
                                  'Satisfactorio!',
                                  'Se ha eliminado correctamente el cliente',
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

    $("#cancelar-editarCliente").click(function(){
        $("#id-cliente").html("");
        $("#digitoDeVerificacion").html("");
        document.getElementById("form-editarCliente").reset();
    });
        
    $("#form-añadirCliente").submit(function(event){
        event.preventDefault();
        var data;
            data = {
                "id" : $("#input-id-cliente").val(),
                "digitoDeVerificacion" : $("#input-digito-de-verificacion-cliente").val(),
                "nombre" : $("#input-nombre-cliente").val(),
                "direccion" : $("#input-direccion-cliente").val(),
                "ciudad" : $("#input-ciudad-cliente").val(),
                "email" : $("#input-email-cliente").val(),
                "telefono" : $("#input-telefono-cliente").val(),
                "celular" : $("#input-celular-cliente").val(),
                "clasificacion" : $("#input-clasificacion-cliente").val()
            }
            $.ajax({
                url: '../assets/php/Controllers/CCliente.php?method=registrarCliente',
                type: 'POST',
                data: data,
                success:function(data){  
                  if(data!=""){
                    if(data==1){
                        $("#añadirCliente").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha registrado correctamente el cliente',
                              'success'
                            );
                            document.getElementById("form-añadirCliente").reset();
                            loadData(); 
                        },500); 
                    }else if(data==0){
                        $("#añadirCliente").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Ha ocurrido un error, vuelva a intentar',
                              'error'
                            );
                            document.getElementById("form-añadirCliente").reset();
                            loadData();  
                        },500);
                    }else if(data==2){
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Al parecer este numero de identificacion ya esta registrado',
                              'error'
                            );
                        },500);
                    }
                  }
                }   
            });

    });

    $("#form-editarCliente").submit(function(event){
        event.preventDefault();
        var data;
            data = {
                "id" : $("#input-id-editar").val(),
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
                url: '../assets/php/Controllers/CCliente.php?method=editarCliente',
                type: 'POST',
                data: data,
                success:function(data){ 
                  if(data!=""){
                    if(data==1){
                        $("#modal-editar-cliente").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha editado correctamente el cliente',
                              'success'
                            );
                            $("#id-cliente").html("");
                            $("#digitoDeVerificacion").html("");
                            document.getElementById("form-editarCliente").reset();
                        },500); 
                    }else if(data==0){
                        $("#modal-editar-cliente").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Ha ocurrido un error, vuelva a intentar',
                              'error'
                            );
                            $("#id-cliente").html("");
                            $("#digitoDeVerificacion").html("");
                            document.getElementById("form-editarCliente").reset();
                        },500);
                    }else if(data==3){
                        $("#modal-editar-cliente").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Opps, no se ha encontrado el cliente para editar',
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

    $("#cancelar-añadirCliente").click(function(){
        document.getElementById("form-añadirCliente").reset();
    });



}); 
