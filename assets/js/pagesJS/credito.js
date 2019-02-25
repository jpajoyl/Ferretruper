$(document).ready(function() {

	$(window).load(function(){
	 	loadData(0);
        $("#ver-pagados").fadeIn(0); 
	});

    $("#ver-pagados").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(1);
        $("#volver-principal").fadeIn(0);
    });

    $("#volver-principal").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(0);
        $("#ver-pagados").fadeIn(0);
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function fechaToString(date,plazo){
        fecha = new Date(date);
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        fecha.setDate(fecha.getDate() + plazo);
        return(fecha.toLocaleDateString("es-ES", options));

    }

	function loadData(pagados){
        window.table=$('#table-creditos').DataTable({
            "ajax":{
                "method":"POST",
                "url":"../assets/php/Controllers/CCredito.php?method=verCreditos&activos="+pagados,
                "dataSrc": function(data){
                    if(data == 3){
                        return [];
                    }else {
                        return data.creditos;
                    }
                }
            },
            "autoWidth": false,
            "columns":[
            {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0,
                        "data":           null
            },
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {"data":"VENTAS_id_venta"},
            {"data":"numero_identificacion"},
            {"data":function (data, type, row){
                return numberWithCommas(data.total);
            }},
            {"data":function (data, type, row){
                return data.fecha+" / "+fechaToString(data.fecha,data.plazo);
            }},//FECHA
            {"data":function (data, type, row){
                if(data.estado==0){
                    return "Activo";
                }else{
                    return "Pagado";
                }
            }},
            {"data":function (data, type, row){
                if(data.estado==0){
                    return "<center><button class='btn btn-primary btn-xs abonar-credito' title='Agregar abono'><i class='fa fa-money'></i></button></button></center>";
                }else{
                    return "";
                }
            }}
            ],
            "order": [[ 1, 'asc' ]],
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

        table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        agregarAbono("#table-creditos tbody",table);
        
    }

    function agregarAbono(tbody,table){
        $(tbody).on("click", ".abonar-credito", function(){
      
        });
    }

    $('#table-creditos tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            var data=row.data();
             var contenidoCliente='<table id="table-cliente-credito" class="table table-responsive-xl table-bordered">'+
            '<thead>'+
                '<tr>'+
                    '<th scope="col">Identificacion</th>'+
                    '<th scope="col">Nombre</th>'+
                    '<th scope="col">Direccion</th>'+
                    '<th scope="col">Telefono/Celular</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody>'+
                '<tr>'+
                    '<td class="id-cliente">'+data.numero_identificacion+'</td>'+
                    '<td class="nombre-cliente">'+data.nombre+'</td>'+
                    '<td class="direccion-cliente">'+data.direccion+' '+data.ciudad+'</td>'+
                    '<td class="telefonos-cliente">'+data.telefono+' / '+data.celular+'</td>'+
                '</tr>'+
            '</tbody></table>';
            $.ajax({
                url: '../assets/php/Controllers/CCredito.php?method=verAbonosCredito',
                type: 'POST',
                data: {"idTipoVenta":data.id_tipo_venta},
                success:function(data){
                    if(data!=""){
                        if(data!=3){
                            var contenido='<table id="table-abonos-credito" class="table table-responsive-xl table-bordered">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th scope="col">No</th>'+
                                    '<th scope="col">Valor pagado</th>'+
                                    '<th scope="col">Fecha abono</th>'+
                                    '<th scope="col"></th>'
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                            var contador=1;
                            $.map($.parseJSON(data).abonos, function(dataAbonos) {
                                contenido+='<tr>'+
                                        '<td class="id-abono">'+contador+'<input type="hidden" id="input-id-abono" value='+dataAbonos.id_abono+'></td>'+
                                        '<td class="valor-abono">'+numberWithCommas(dataAbonos.valor)+'</td>'+
                                        '<td class="fecha-abono">'+fechaToString(dataAbonos.fecha,0)+'</td>'+
                                        '<td class="editar-abono"><center><button class="btn btn-warning btn-xs editar-abono" title="Editar valor abono"><i class="fa fa-pencil"></i></button></button></center></td>'+
                                        '</tr>';
                                        contador++;
                            });
                            contenido+='</tbody></table>';
                            row.child(contenidoCliente+contenido).show();
                        }else{
                            var contenido='<div class="alert alert-danger" role="alert">Este producto no tiene ningun proveedor aun</div>';
                            row.child(contenidoCliente+contenido).show();
                        }
                        
                    }  
                }
            }).always(function(){
                tr.addClass('shown');
            });
        }
    });
});