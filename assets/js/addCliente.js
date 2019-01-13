$(document).ready(function(){
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
});