
$(document).ready(function () {
    urlproductos = "";
    HayProd = "Si";
    switch(QueryString.prod) {
        case "coleccionss21": urlproductos = "../data/coleccionss21.json"; break;
        default: HayProd = "No"; break;
    }


    if(HayProd == "Si"){
        $.getJSON(urlproductos, function (data) {
            contador = 1;
            cascaron="";
            $.each(data, function (key, val) {
                if(contador == 1){
                    cascaron += '<div class="row mb-5">';
                }
    
                cascaron += '<div class="col-md-6 interactive text-center">'+
                    '<a href="cotizar.html?prod=' + val.id + '&lista=' + QueryString.prod + '" class="portafolioWrap d-block">'+
                '<img src="../' + val.imagen + '" alt="' + val.nombre+'" class="img mx-auto">'+
                '<div class ="mcotizar"><strong>COTIZAR</strong></div>'+
                '</a>'+
                '<h4 class="mt-3">' + val.nombre+'</h4>'+
                '<p>' + val.composicion + '</p>';
                
                $.each(val.colores, function (key1, val1) {
                    cascaron += '<div class="d-inline-block p-3 me-2" style="background-color:' + val1 +'"></div>';
                });
                
                cascaron += '</div>';
                
    
                if(contador == 2){
                    cascaron += '</div>';
                }
                contador++;
                if(contador == 3){
                    contador = 1;
                }
            });
    
            $("#coleccion").prepend(cascaron);
        });
    }else{
        $("#coleccion").prepend("<h1 class='text-center'>NO SE ENCONTRARON <br>PRODUCTOS</h1>");

    }


    
});

