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
                        '<a href="cotizar.html?idProd=' + obj[index].id +'" class="portafolioWrap d-block">' +
                        '<img src="' + result + '" alt="' + obj[index].nombre + '" class="img mx-auto">' +
                        '<div class ="mcotizar"><strong>COTIZAR</strong></div>' +
                        '</a>' +
                        '<h4 class="mt-3">' + obj[index].nombre + '</h4>' +
                        '<p>' + obj[index].composicion + '</p>';

                    arrayColores = obj[index].colores.split(",");
                    if (arrayColores.length > 1){
                        for (let i = 0; i < arrayColores.length; i++) {
                            cascaron += '<div class="d-inline-block p-3 me-2" style="background-color:' + arrayColores[i] + '"></div>';
                        }
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

