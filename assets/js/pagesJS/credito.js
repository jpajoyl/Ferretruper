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
          "processing": true,
          "serverSide": true,
          "ajax": "../assets/php/Controllers/CCredito.php?method=verCreditos&activos="+pagados,
          "destroy":true,
          "autoWidth": false,
          "columnDefs": [ {"render": function (data, type, row) {
                        return "";
                    },
                    className: "details-control",
                    "targets": [0]} ],
          "responsive":true,
          "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se han encontrado registros",
            "info": "(Creditos) Pagina _PAGE_ de _PAGES_",
            "search": "Buscar",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": ""
          }
        });

        
    }

    function cargarAbonos(elemento,detailsControl){
        var tr = $(elemento).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() && detailsControl) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            var dataTable=table.row($(elemento).parents("tr")).data();
            $.ajax({
                url: '../assets/php/Controllers/CCliente.php?method=obtenerCliente',
                type: 'POST',
                data: {"numero_identificacion":dataTable[2]},
                success:function(data){
                    if(data!=""){
                        if(data!=3){
                            var data=$.parseJSON(data);
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
                                    '<td class="id-cliente">'+dataTable[2]+'</td>'+
                                    '<td class="nombre-cliente">'+data.nombre+'</td>'+
                                    '<td class="direccion-cliente">'+data.direccion+'</td>'+
                                    '<td class="telefonos-cliente">'+data.telefono+'/'+data.celular+'</td>'+
                                '</tr>'+
                            '</tbody></table>';
                            $.ajax({
                                url: '../assets/php/Controllers/CCredito.php?method=verAbonosCredito',
                                type: 'POST',
                                data: {"idTipoVenta":dataTable[1]},
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
                                            var pagado=0;
                                            $.map($.parseJSON(data).abonos, function(dataAbonos) {
                                                contenido+='<tr>'+
                                                        '<td class="id-abono">'+contador+'<input type="hidden" id="input-id-abono" value='+dataAbonos.id_abono+'></td>'+
                                                        '<td class="valor-abono">'+numberWithCommas(dataAbonos.valor)+'</td>'+
                                                        '<td class="fecha-abono">'+fechaToString(dataAbonos.fecha,0)+'</td>'+
                                                        '<td class="editar-abono"><center><button class="btn btn-danger btn-xs eliminar-abono" title="Eliminar abono" id-abono="'+dataAbonos.id_abono+'"><i class="fa fa-trash-o"></i></button></button></center></td>'+
                                                        '</tr>';
                                                        contador++;
                                                pagado=pagado+dataAbonos.valor;
                                            });
                                            var totalAPagar=parseInt(dataTable[3].replace(",",""));
                                            contenido+='<tr><td class="table-primary"><center><strong>Saldo restante:</strong></center></td><td class="table-primary"><strong>'+numberWithCommas(totalAPagar-pagado)+'</strong></td><td colspan="2"></td></tr></tbody></table>';
                                            
                                            row.child(contenidoCliente+contenido).show();
                                        }else{
                                            var contenido='<div class="alert alert-danger" role="alert">No hay abonos registrados</div>';
                                            row.child(contenidoCliente+contenido).show();
                                        }
                                        
                                    }  
                                }
                            }).always(function(){
                                tr.addClass('shown');
                            });
                        }else{
                            swal("Error","A ocurrido un error, recarga la pagina por favor","error");
                        }
                    }
                }
            });      
        }
    }

    $('#table-creditos tbody').on('click', 'td.details-control', function () {
        cargarAbonos(this,true);
    });

    $(document).on("click", ".emitir-factura-credito", function(){
        var idVenta=$(this).attr("id-venta");
        window.open("../assets/php/Controllers/CVenta.php?method=emitirFactura&id-venta="+idVenta);
    });

    $(document).on("click", ".agregar-abono", function(){
        var idVenta=$(this).attr("id-venta");
        var input="";
        input=input+'<div class="form-group">'+
                            '<input type="text" class="form-control" id="input-usuario" placeholder="Usuario" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="password" class="form-control" id="input-password" placeholder="Contraseña" required autocomplete="off">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<input type="number" class="form-control" id="input-abono" placeholder="Valor abono" required autocomplete="off">'+
                        '</div>';
        swal({
            title: 'Agregar abono',
            html: input,
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#22C13C',
            cancelButtonColor: '#9A9A9A',
            confirmButtonText: 'Agregar!',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                var data={
                    'usuario':$("#input-usuario").val(),
                    'password':$("#input-password").val()
                }
                $.ajax({
                    url: '../assets/php/Controllers/CAdministracion.php?method=comprobarAdministrador',
                    type: 'POST',
                    data: data,
                    success:function(data){
                        if(data==1){
                            var valorAbono=$("#input-abono").val();
                            data={
                                "idVenta":idVenta,
                                "valorAbono":valorAbono
                            }
                            $.ajax({
                                url: '../assets/php/Controllers/CCredito.php?method=añadirAbono',
                                type: 'POST',
                                data: data,
                                success:function(data){
                                    console.log(data);
                                    if(data!=""){
                                        if(data==1){
                                            var elemento=".span-id-venta[id-venta="+idVenta+"]";
                                            cargarAbonos(elemento,false);
                                        }else if(data==0){
                                            swal("Error","No se ha podido agregar el abono, revise e intentelo nuevamente","error");
                                        }
                                    }
                                }
                            });
                        }else if(data==0 || data==3){
                            setTimeout(function(){
                                Swal(
                                    'Error!',
                                    'El usuario y/o contraseña son incorrectos',
                                    'error'
                                );
                            },100);  
                        }
                    }
                });
            }
        });

    });

    $(document).on("click", ".eliminar-abono", function(){
        var idAbono=$(this).attr("id-abono");
        $.ajax({
            url: '../assets/php/Controllers/CCredito.php?method=eliminarAbono',
            type: 'POST',
            data: {"idAbono":idAbono},
            success:function(data){
                if(data!=""){
                    if(data==1){
                        var elemento=".span-id-venta[id-venta="+idVenta+"]";
                        cargarAbonos(elemento,false);
                        swal("Error","No se ha podido agregar el abono, revise e intentelo nuevamente","error");
                    }
                }
            }
        });
    });
});