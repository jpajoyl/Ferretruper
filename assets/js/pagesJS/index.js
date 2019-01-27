$(document).ready(function() {

	$(window).load(function(){
	 	loadData();
	});

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
    }
});