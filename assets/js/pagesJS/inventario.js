$(document).ready(function() {

	 $(window).load(function(){
	 	loadData();
	  }

	function loadData(){
    window.table=$('#table-productos').DataTable({
        "ajax":{
            "method":"POST",
            "url":"../assets/php/Controllers/CInventario.php?method=verProductos"
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
        {className: "table-proveedores-nit-proveedor","data":"numero_identificacion"},
        {"data":"digito_de_verificacion"},
        {"data":"nombre"},
        {"data":"email"},
        {"data":"direccion"},
        {"data":"ciudad"},
        {"data":"telefono"},
        {"defaultContent":"<button class='btn btn-primary btn-xs editar-proveedor'><i class='fa fa-pencil'></i></button>\
        </button><button class='btn btn-danger btn-xs eliminar-proveedor'><i class='fa fa-trash-o'></i></button>"}
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
    viewProveedor("#table-proveedores tbody",table);
    getDataEdit("#table-proveedores tbody",table);
    desactivarProveedor("#table-proveedores tbody",table);
}
}