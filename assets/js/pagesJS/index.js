$(document).ready(function() {

	$(window).load(function(){
       loadData();
       getVenta();
   });

	function getVenta(){
		$.ajax({
            url: '../assets/php/Controllers/CVenta.php?method=obtenerVenta',
            type: 'POST',
            success:function(data){
                console.log(data);
                if(data!=3){
                    if(data.response==1){
                            //CARGAR DATOS VENTA
                    }
                }else{
                    $("#no-venta").fadeIn(0);
                }
            }
        });
	}

	function loadData(){
        window.table=$('#table-productos').DataTable({
            "ajax":{
                "method":"POST",
                "url":"../assets/php/Controllers/CProducto.php?method=verProductos",
                "dataSrc": function(data){
                    if(data == 3){
                        return [];
                    }else {
                        return data.productos;
                    }
                }
            },
            "autoWidth": false,
            "columns":[
            {"data":"id_producto"},
            {"data":"nombre"},
            {"data":"referencia_fabrica"},
            {"data":"codigo_barras"},
            {"data":"unidades_totales"},
            {"data":"precio_mayor_inventario"},
            {"data":function (data, type, row){
            	if(parseInt(data.unidades_totales)>=0) {
            		return "<center><button class='btn btn-success btn-xs añadir-producto'><i class='fa fa-plus-circle'></i></button>\
                    </button></center>";
                }else{
                  return "";
              }
          }}
          ],
          "createdRow":function (row, data, index){
             if(parseInt(data.unidades_totales) == 0){
                  $(row).toggleClass('tr-warning');
              }
              if(parseInt(data.unidades_totales) < 0){
                  $(row).toggleClass('tr-locked');
            }
          },
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
        añadirProducto("#table-productos tbody",table);
    }

    function añadirProducto(tbody,table){
        $(tbody).on("click", ".añadir-producto", function(){
            var data=table.row($(this).parents("tr")).data();
            var tbody='<tr id="añadir-producto-venta">'+
                        '<form autocomplete="off" action="#" id="form-añadir-producto-venta">'+
                            '<td width="15%" id="td-id-producto">'+
                                data.id_producto+'<input type="hidden" id="input-id-producto" value="'+data.id_producto+'">'+
                            '</td>'+
                            '<td>'+
                                data.nombre+
                            '</td>'+
                            '<td width="15%">'+
                                data.precio_mayor_inventario+'<input type="hidden" id="input-precio-inventario-producto" value="'+data.precio_mayor_inventario+'">'+
                            '</td>'+
                            '<td width="15%" id="td-cantidad-producto">'+
                                '<input type="number" class="form-control" id="input-cantidad-producto" placeholder="cantidad" autocomplete="off">'+
                            '</td>'+
                            '<td width="15%" id="total-venta-producto"></td>'+
                            '<td width="10%">'+
                                '<center><button class="btn btn-danger btn-xs añadir-producto"><i class="fa fa-trash"></i></button>\
                                </button></center>'+
                            '</td>';
            $("#no-venta").fadeOut(0);
            $("#body-table-venta").append(tbody);
        });
    }

    // $('#form-añadir-producto-venta').bind("keypress", function(e) { 
    //     if (e.keyCode == 13) {    
    //         $(this).submit();
    //         return false; 
    //     } 
    // }); 

    // $("#form-añadir-producto-venta").submit(function(event){
    //     event.preventDefault();
    //     var idProducto=$("#input-id-producto").val();

    // });
});