$(function () {
    $.ajax({
        dataType: "html",
        type: "GET",
        url: "../data/datos.php",
        data: { "id": QueryString.prod},
        success: function (d) {
            // m(d);
            const obj = JSON.parse(d);
            if(obj.length > 0){
                contador = 1;
                cascaron = "";
                for (let index = 0; index < obj.length; index++) {
                    if (contador == 1) {
                        cascaron += '<div class="row mb-5">';
                    }
                    // m(obj[index]);
                    imagenPortada = obj[index].imagen.split(",");
                    result = imagenPortada[0].replace("../../", "../");

                    cascaron += '<div class="col-md-6 interactive text-center">' +
                        '<a href="cotizar.html?idProd=' + obj[index].id +'&nombre=' + obj[index].nombre + '&medidas=' + obj[index].medidas + '&imagen=' + obj[index].imagen +
                        '&de=' + obj[index].de + '&composicion=' + obj[index].composicion + '&colores=' + obj[index].colores + '" class="portafolioWrap d-block">' +
                        '<img src="' + result + '" alt="' + obj[index].nombre + '" class="img mx-auto">' +
                        '<div class ="mcotizar"><strong>COTIZAR</strong></div>' +
                        '</a>' +
                        '<h4 class="mt-3">' + obj[index].nombre + '</h4>' +
                        '<p>' + obj[index].composicion + '</p>';

                    arrayColores = obj[index].colores.split(",");
                    for (let i = 0; i < arrayColores.length; i++) {
                        cascaron += '<div class="d-inline-block p-3 me-2" style="background-color:' + arrayColores[i] + '"></div>';
                    }

                    cascaron += '</div>';

                    if (contador == 2) {
                        cascaron += '</div>';
                    }
                    contador++;
                    if (contador == 3) {
                        contador = 1;
                    }
        
                }
                $("#coleccion").prepend(cascaron);
            }else{
                $("#coleccion").prepend("<h1 class='text-center'>NO SE ENCONTRARON <br>PRODUCTOS</h1>");
            }
        }
    });
});
/*
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
*/
