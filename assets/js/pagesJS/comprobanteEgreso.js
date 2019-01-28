$(document).ready(function() {
		$("#form-factura-compra").submit(function(event){
	        event.preventDefault();
	        var data={
	        	"numeroFactura":$("#input-numero-factura-compra").val()
	        }
	            $.ajax({
	                url: '../assets/php/Controllers/CcomprobanteEgreso.php?method=buscarFacturaCompra',
	                type: 'POST',
	                data: data,
	                success:function(data){  
	                  if(data!=""){
	                  	alert(data);
	                    if(data==1){
	                        $("#añadirCliente").modal("hide");
	                        
	                    }else if(data==0){
	                        $("#añadirCliente").modal("hide");
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