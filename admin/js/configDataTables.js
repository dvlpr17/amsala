
$(document).ready(function () {



    var table = $('#productos').DataTable({
        "pageLength": 100,
        scrollY: "500px",
        scrollX: true,
        scrollCollapse: true,

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },


        "processing": true,
        "serverSide": true,
        "sAjaxSource": "ssProductos.php",
        "columnDefs": [{
            targets: 3,
            createdCell: function (td, cellData, rowData, row, col) {
                if(rowData[3].length > 0){
                    res = rowData[3].split(",");
                    $(td).html("");
                    for (var col = 0; col < res.length; col++) {
                        $(td).append('<div class="color d-inline-block p-3 me-2" elcolor="' + res[col] + '" style="background-color:' + res[col] + ';"></div>');
                    }
                }

            }
        },
        {
            targets: 6,
            createdCell: function (td, cellData, rowData, row, col) {
                if(!rowData[6]){

                }else{
                    res = rowData[6].split(",");
                    $(td).html("");
                    for (var col = 0; col < res.length; col++) {
                        $(td).append('<img class="img-thumbnail" src="'+res[col]+'" width="50">');
                    }
                }
            }

        }]        

    });
    table.order([0, 'desc']).draw();







});