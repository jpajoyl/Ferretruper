$(document).ready(function() {
    $.ajax({
        url: '../assets/php/Controllers/CFactura.php?method=obtenerInfoFacturaCarta',
        type: 'POST',
        data: "",
        success:function(data){  
          if(data!=""){
            var array=JSON.parse(data);
            var datos=array.informacion[0];
            document.getElementById ("numero-dian-carta").value = parseInt(datos.numero_dian);
            document.getElementById ("r-descripcion-carta").value = datos.r_descripcion;
            document.getElementById ("i-descripcion-carta").value = datos.i_descripcion;
          }
        }   
    });
    $.ajax({
        url: '../assets/php/Controllers/CFactura.php?method=obtenerInfoFacturaPos',
        type: 'POST',
        data: "",
        success:function(data){  
          if(data!=""){
            var array=JSON.parse(data);
            var datos=array.informacion[0];
            document.getElementById ("numero-dian-pos").value = parseInt(datos.numero_dian);
            document.getElementById ("r-descripcion-pos").value = datos.r_descripcion;
            document.getElementById ("i-descripcion-pos").value = datos.i_descripcion;
          }
        }   
    });
    $("#form-pos").submit(function(event){
      event.preventDefault();
      var data;
      data = {
        "numeroDianPos" : $("#numero-dian-pos").val(),
        "RDescripcionPos" : $("#r-descripcion-pos").val(),
        "IDescripcionPos" : $("#i-descripcion-pos").val()
      }
      Swal({
        title: 'Estas seguro?',
        text: "Se actualizará la informacion y el numero de la factura!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, editar!',
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: '../assets/php/Controllers/Cfactura.php?method=editarFacturaPos',
            type: 'POST',
            data: data,
            success:function(data){  
              if(data!=""){
                if (data==1) {
                    Swal(
                      'Satisfactorio!',
                      'Se ha editado correctamente la informacion de la factura',
                      'success'
                      );
                }else{
                    Swal(
                      'Error!',
                      'Ha ocurrido un error, vuelva a intentar',
                      'error'
                      );
                }
              }
            }   
          });
        }
      }); 
    });
    $("#form-carta").submit(function(event){
      event.preventDefault();
      var data;
      data = {
        "numeroDianCarta" : $("#numero-dian-carta").val(),
        "RDescripcionCarta" : $("#r-descripcion-carta").val(),
        "IDescripcionCarta" : $("#i-descripcion-carta").val()
      }
      Swal({
        title: 'Estas seguro?',
        text: "Se actualizará la informacion y el numero de la factura!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, editar!',
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: '../assets/php/Controllers/Cfactura.php?method=editarFacturaCarta',
            type: 'POST',
            data: data,
            success:function(data){  
              if(data!=""){
                if (data==1) {
                    Swal(
                      'Satisfactorio!',
                      'Se ha editado correctamente la informacion de la factura',
                      'success'
                      );
                }else{
                    Swal(
                      'Error!',
                      'Ha ocurrido un error, vuelva a intentar',
                      'error'
                      );
                }
              }
            }   
          });
        }
      }); 
    });
});