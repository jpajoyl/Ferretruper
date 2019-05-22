$(document).ready(function() {
    $(window).load(function(){
        loadData();
    });


    function loadData(){
        /*
            0:id_usuario
            1:numero_identificacion
            2:digito_de_verificacion
            3:nombre
            4:email
            5:Direccion
            6:ciudad
            7:telefono
            9:celular
            10:clasificacion
        */
        window.table=$('#table-empleados').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":"../assets/php/Controllers/CEmpleado.php?method=verEmpleado",
                "autoWidth": false,
                "destroy":true,
                "responsive":true,
                "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se han encontrado registros",
                "info": "(empleados) Pagina _PAGE_ de _PAGES_",
                "search": "Buscar",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": ""
                }
            });
        getDataEdit("#table-empleados tbody",table);
        desactivarEmpleado("#table-empleados tbody",table);
    }


    function getDataEdit(tbody,table){
        $(tbody).on("click", ".editar-empleado", function(){
            /*
            0:id_usuario
            1:numero_identificacion
            2:digito_de_verificacion
            3:nombre
            4:email
            5:Direccion
            6:ciudad
            7:telefono
            9:celular
            10:clasificacion
        */
            var data=table.row($(this).parents("tr")).data();
            $("#id-empleado").html(data[0]);
            $("#input-id-editar").val(data[0]);
            $("#input-nombre-editar").val(data[1]);
            $("#input-direccion-editar").val(data[3]);
            $("#input-ciudad-editar").val(data[4]);
            $("#input-email-editar").val(data[2]);
            $("#input-telefono-editar").val(data[5]);
            $("#input-celular-editar").val(data[6]);       
            $("#modal-editar-empleado").modal("show");
        });
    }

    function desactivarEmpleado(tbody,table){
        $(tbody).on("click", ".eliminar-empleado", function(){
            var data=table.row($(this).parents("tr")).data();
            Swal({
              title: 'Estas seguro?',
              text: "Se eliminara el empleado "+data[1]+"!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Eliminarlo!',
              cancelButtonText: "Cancelar"
            }).then((result) => {
              if (result.value) {
                $.ajax({
                    url: '../assets/php/Controllers/CEmpleado.php?method=desactivarEmpleado',
                    type: 'POST',
                    data: {"id":data[0]},
                    success:function(data){  
                        console.log(data);
                      if(data!=""){
                        if(data==1){
                            loadData();
                            setTimeout(function(){
                                Swal(
                                  'Satisfactorio!',
                                  'Se ha eliminado correctamente el empleado',
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

    $("#cancelar-editarEmpleado").click(function(){
        $("#id-empleado").html("");
        //$("#digitoDeVerificacion").html("");
        document.getElementById("form-editarEmpleado").reset();
    });
        
    $("#form-añadirEmpleado").submit(function(event){
        event.preventDefault();
        var data;
            data = {
                "id" : $("#input-id-empleado").val(),
                "usuario" : $("#input-usuario-empleado").val(),
                "contraseña" : $("#input-contrasena-empleado").val(),
                "nombre" : $("#input-nombre-empleado").val(),
                "direccion" : $("#input-direccion-empleado").val(),
                "ciudad" : $("#input-ciudad-empleado").val(),
                "email" : $("#input-email-empleado").val(),
                "telefono" : $("#input-telefono-empleado").val(),
                "celular" : $("#input-celular-empleado").val()//,
            }
            $.ajax({
                url: '../assets/php/Controllers/CEmpleado.php?method=registrarEmpleado',
                type: 'POST',
                data: data,
                success:function(data){  
                  if(data!=""){
                    if(data==1){
                        $("#añadirEmpleado").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha registrado correctamente el empleado',
                              'success'
                            );
                            document.getElementById("form-añadirEmpleado").reset();
                            loadData(); 
                        },500); 
                    }else if(data==0){
                        $("#añadirEmpleado").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Ha ocurrido un error, vuelva a intentar',
                              'error'
                            );
                            document.getElementById("form-añadirEmpleado").reset();
                            loadData();  
                        },500);
                    }else if(data==2){
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Al parecer este numero de identificacion ya esta registrado, se volverá a activar el empleado',
                              'error'
                            );
                        },500);
                    }
                  }
                }   
            });

    });

    $("#form-editarEmpleado").submit(function(event){
        event.preventDefault();
        var data;
            data = {
                "id" : $("#input-id-editar").val(),
                //"digitoDeVerificacion" : $("#input-digito-de-verificacion-editar").val(),
                "nombre" : $("#input-nombre-editar").val(),
                "direccion" : $("#input-direccion-editar").val(),
                "ciudad" : $("#input-ciudad-editar").val(),
                "email" : $("#input-email-editar").val(),
                "telefono" : $("#input-telefono-editar").val(),
                "celular" : $("#input-celular-editar").val(),
                "usuario" : $("#input-usuario-editar").val(),
                "contrasena" : $("#input-contrasena-editar").val()
                //,
                //"clasificacion" : $("#input-clasificacion-editar").val()
            }
            $.ajax({
                url: '../assets/php/Controllers/CEmpleado.php?method=editarEmpleado',
                type: 'POST',
                data: data,
                success:function(data){ 
                  if(data!=""){
                    if(data==1){
                        $("#modal-editar-empleado").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Satisfactorio!',
                              'Se ha editado correctamente el empleado',
                              'success'
                            );
                            $("#id-empleado").html("");
                            document.getElementById("form-editarempleado").reset();
                        },500); 
                    }else if(data==0){
                        $("#modal-editar-empleado").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Ha ocurrido un error, vuelva a intentar',
                              'error'
                            );
                            $("#id-empleado").html("");
                            document.getElementById("form-editarempleado").reset();
                        },500);
                    }else if(data==3){
                        $("#modal-editar-empleado").modal("hide");
                        setTimeout(function(){
                            Swal(
                              'Error!',
                              'Opps, no se ha encontrado el empleado para editar',
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

    $("#cancelar-añadirEmpleado").click(function(){
        document.getElementById("form-añadirEmpleado").reset();
    });



}); 
