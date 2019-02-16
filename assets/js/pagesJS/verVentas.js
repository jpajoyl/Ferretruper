$(document).ready(function() {
    $(window).load(function(){
        loadData(false);
        $("#ver-papelera").fadeIn(0);
    });

    $("#ver-papelera").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(true);
        $("#volver-principal").fadeIn(0);
    });

    $("#volver-principal").click(function(event){
        event.preventDefault();
        $(this).fadeOut(0);
        loadData(false);
        $("#ver-papelera").fadeIn(0);
    });
    function emitirFacturaAnulada(tbody,table){
        $(tbody).on("click", ".emitir-factura", function(){
            var data=table.row($(this).parents("tr")).data();
            window.open("../assets/php/Controllers/CVenta.php?method=emitirFactura&id-venta="+data.id_venta);
        });
    }
    function anularVenta(tbody,table){
        $(tbody).on("click", ".anular-factura", function(){
            var data=table.row($(this).parents("tr")).data();
            Swal({
              title: 'Estas seguro?',
              text: "Se anulara la factura "+data.numero_dian+"!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, ANULARLA!',
              cancelButtonText: "Cancelar"
          }).then((result) => {
              if (result.value) {
                $.ajax({
                    url: '../assets/php/Controllers/CVenta.php?method=anularVenta',
                    type: 'POST',
                    data: {"idVenta":data.id_venta},
                    success:function(data){  
                      if(data!=""){
                        if(data==1){
                            loadData(false);
                            setTimeout(function(){
                                Swal(
                                  'Satisfactorio!',
                                  'Se ha anulado correctamente la factura',
                                  'success'
                                  );
                            },500); 

                        }else if(data==0 || data==3){
                            loadData(false); 
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
    function loadData(papelera){
        if(!papelera){
            window.table=$('#table-ventas').DataTable({
                "ajax":{
                    "method":"POST",
                    "url":"../assets/php/Controllers/CVenta.php?method=verVentas",
                    "dataSrc": function(data){
                        if(data == 3){
                            return [];
                        }else {
                            return data.ventas;
                        }
                    }
                },
                "autoWidth": false,
                "columns":[
                {"data":"id_venta"},
                {"data":"fecha"},
                {"data":"total"},
                {"data":"numero_dian"},
                {"defaultContent":"<center></button><button class='btn btn-danger btn-xs anular-factura'><i class='fa fa-trash-o'></i></button></center>"}
                ],
                "destroy":true,
                "responsive":true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado registros",
                    "info": "(_MAX_ ventas) Pagina _PAGE_ de _PAGES_",
                    "search": "Buscar",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(registros disponibles _MAX_)"
                }
            });
            anularVenta("#table-ventas tbody",table);
        }else{
            window.table=$('#table-ventas').DataTable({
                "ajax":{
                    "method":"POST",
                    "url":"../assets/php/Controllers/CVenta.php?method=verVentasAnuladas",
                    "dataSrc": function(data){
                        if(data == 3){
                            return [];
                        }else {
                            return data.ventas;
                        }
                    }
                },
                "autoWidth": false,
                "columns":[
                {"data":"id_venta"},
                {"data":"fecha"},
                {"data":"total"},
                {"data":"numero_dian"},
                {"defaultContent":"<center></button><button class='btn btn-success btn-xs emitir-factura'><i class='fa fa-chevron-circle-left'></i></button></center>"}
                ],
                "destroy":true,
                "responsive":true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado registros",
                    "info": "(_MAX_ ventas) Pagina _PAGE_ de _PAGES_",
                    "search": "Buscar",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(registros disponibles _MAX_)"
                }
            });
            emitirFacturaAnulada("#table-ventas tbody",table);
        }
    }

});