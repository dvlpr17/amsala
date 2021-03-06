let colorUnico = "";
$(document).ready(function () {

    if (QueryString.prod){
        cascaron = '<div class="row my-5">';
        LaUrl = "../data/"+QueryString.lista+".json";
        $.getJSON(LaUrl, function (data) {
            $.each(data, function (key, val) {
                if (val.id == QueryString.prod){
                    cascaron += '<div id="LasFotos" class="col-lg-6">'+
                        '<img class="w-100" src="../' + val.imagen + '" alt="' + val.nombre+'">' +
                        '<img class="w-100" src="../' + val.imagen + '" alt="' + val.nombre+'">' +
                    '</div>' +
                    '<div id="LaInformacion" class="col-lg-6"><div id="LaInfo">' +
                    '<h2 id="nombre" class="comforta mt-lg-0 mt-5">'+val.nombre+'</h2>' +
                        '<p>' + val.desc + '</p>';

                    // color = 1;
                    $.each(val.colores, function (key1, val1) {
                        if(val1 == "unico"){
                            colorUnico = "unico";
                        }else{
                            cascaron += '<div class="color d-inline-block p-3 me-2" elcolor="'+val1+'" style="background-color:' + val1 + '"></div>';
                        }
                    });
                    

                    cascaron += '<h5 class="borde comforta mt-4">MEDIDAS</h5>' +
                    '<ul class="list-unstyled striped-list">';

                    $.each(val.medidas, function (key2, val2) {
                        cascaron += '<li class="d-flex justify-content-between px-3 py-1">' +
                        '<span class="ptop-6">'+ val2 +'</span>' +
                        '<div class="LasMedidas">' +
                        '<button class="botones menos">-</button>' +
                        '<input type="text" class="cajaCantidad" value="0">' +
                        '<button class="botones mas">+</button>' +
                        '</div>' +
                        '</li>';
                    });

                    cascaron += '</ul><h5 class="borde comforta mt-4">COMPOSICI??N</h5>' +
                    '<p>' + val.composicion+'</p>' +
                    '<h5 class="borde comforta mt-4">CUIDADO</h4>' +
                    '<ul class="list-unstyled mb-5 alertaCotizacion1">' +
                    '<li> <span class="icon-cares-6"></span> LAVAR A MAQUINA MAX. 30??C. CENTRIFUGADO CORTO</li>' +
                    '<li class="pt-3"> <span class="icon-cares-14"></span> NO USAR LEJ??A / BLANQUEADOR</li>' +
                    '<li class="pt-3"> <span class="icon-cares-17"></span> PLANCHAR MAXIMO 110 ?? C</li>' +
                    '<li class="pt-3"> <span class="icon-cares-28"></span> NO USAR SECADORA</li>' +
                    '</ul>' +
                        '<button type="submit" elid="'+val.id+'" class="agregar btn btn-amsala mb-3 px-5" >AGREGAR A COTIZACI??N</button> ' +
                    '<button id="ver" type="submit" class="btn btn-amsala mb-3 px-5">VER COTIZACI??N</button>' +
                    '</div></div>';

                }
            });
            cascaron += '</div>' 
            $("#DatosProducto").prepend(cascaron);
        });

    }else{
        $("#DatosProducto").prepend("<h1 class='text-center'>No hay Producto</h1>");
    }

    //-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  BOTONES MAS MENOS PARA LA CANTIDAD
    //-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $(document).on('click', '.menos', function () {
        if($(this).parent().children("input").val() > 0){
            valor = parseInt($(this).parent().children("input").val());
            $(this).parent().children("input").val(valor - 1);
        }
    });
    
    $(document).on('click', '.mas', function () {
        valor = parseInt($(this).parent().children("input").val());
        $(this).parent().children("input").val(valor + 1);
    });


});


//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  FUNCION VALIDA CAMPOS NUMERICOS
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

$(document).on('focusin', 'input.cajaCantidad', function () {
    $(this).val(''); $(this).ForceNumericOnly(); 
});

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//ACTUALIZA CANTIDADES AL CLICK EN EL CAMPO DE CANTIDAD
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$(document).on('focusout', 'input.cajaCantidad', function () {
    


    if($(".offcanvas").hasClass("show")){

        if ($(this).val() == '' || $(this).val() == '0') {
            $(this).val('1');
        }
        

        Medida = $(this).parent().parent().parent().find(".medidaMini > p").html();
        Color = $(this).parent().parent().parent().find('.colorMini').find("div").attr("elcolor");
        Nombre = $(this).parent().parent().parent().find(".nombreMini > strong").html();
        laUrl = $(this).parent().parent().parent().find(".imagenMini").find("img").attr("src");
        
        if($(this).val() != '' && $(this).val() > 0){
            addProducto(laUrl, Nombre, Color, Medida, $(this).val());
        }
    }else{

        if ($(this).val() == '' || $(this).val() == '0') {
            $(this).val('0');
        }
    
    }

        
});

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//VALIDACION DE SOLO NUMEROS EN EL CAMPO DE CANTIDAD
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$(document).on('keyup', 'input.cajaCantidad', function () {
    $(this).ForceNumericOnly();
});

jQuery.fn.ForceNumericOnly = function () {
    return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 13 || key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
            })
        })
};

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  Bot??n seleccion de color y medidas
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

$(document).on('click', '.color', function () {
    $(".color").removeClass("bordeSeleccion");
    $(this).addClass("bordeSeleccion");
});

$(document).on('click', '.LasMedidas', function () {
    $(".LasMedidas").removeClass("bordeSeleccion");
    $(this).addClass("bordeSeleccion");
});

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  BOT??N AGREGAR A COTIZACI??N
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
ElColor = "";
LaCantidad = "";
LasMedidas = "";
iconoAlert = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">' +
    '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />' +
    '</svg>';
botonCerrar = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';


$(document).on('click', '#ver', function (event) {
    event.stopPropagation();
    var myOffcanvas = document.getElementById('myOffCanvas');
    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
    bsOffcanvas.show();

    showStorage();
});

$(document).on('click', '.agregar', function (event) {
    $(".alert-danger").remove();
    if ($(".color.bordeSeleccion").attr("elcolor") != undefined || colorUnico == "unico"){
        if ($(".LasMedidas.bordeSeleccion > .cajaCantidad").val() != undefined){


            //LLAMAR OFFCANVAS
            event.stopPropagation();
            var myOffcanvas = document.getElementById('myOffCanvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();

            
            colorUnico == "unico"? ElColor = colorUnico: ElColor = $(".color.bordeSeleccion").attr("elcolor");

            
            if($(".LasMedidas.bordeSeleccion > .cajaCantidad").val() == 0){
                LaCantidad = "1";
            }else{
                LaCantidad = $(".LasMedidas.bordeSeleccion > .cajaCantidad").val();
            }
            LasMedidas = $(".LasMedidas.bordeSeleccion").parent().children("li span").text();
            
            addProducto($("#LasFotos").find("img").attr("src"), $("#LasFotos").find("img").attr("alt"), ElColor, LasMedidas, LaCantidad);
            
            
            setTimeout(function () {showStorage();}, 300);


            // REINICIAR DATOS
            $(".LasMedidas").removeClass("bordeSeleccion");
            $(".color").removeClass("bordeSeleccion");
            $(".cajaCantidad").val(0);

        }else{
            $(".alertaCotizacion1").append("<div class='alert alert-danger alert-dismissible fade show mt-5' role='alert'>" + iconoAlert + " Selecciona una medida " + botonCerrar+"</div>");
        }
    }else{
        $(".alertaCotizacion1").append("<div class='alert alert-danger alert-dismissible fade show mt-5' role='alert'>" + iconoAlert + " Selecciona un color " + botonCerrar+"</div>");
    }


});

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//    BTN PARA ELIMINAR ELEMENTOS DE LA COTIZACI??N
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

$(document).on('click', ".eliminar", function () {
    Medida = $(this).parent().parent().parent().find(".medidaMini > p").html();
    Color = $(this).parent().parent().parent().find('.colorMini').find("div").attr("elcolor");
    Nombre = $(this).parent().parent().parent().find(".nombreMini > strong").html();
  
    eliminaElemento(Medida, Color, Nombre);

    $(this).parent().parent().parent().parent("table").remove();
    
});

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  MUESTRA EL CONTENIDO DE SESION STORAGE EN OFFCANVAS DE BOOTSTRAP
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
function showStorage(){
    if (sessionStorage.length > 0) {
        $(".verCotizacion").removeClass("d-none");
        var jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
        var listado = "";
        $(".offcanvas-body").html("");
        for (i = 0; i < jsonData.length; i++) {

            listado = '<table style="width:100%;background-color:#f8f6f5;"><tr>' +
                '<td class="imagenMini" rowspan="3" style="width:30%"><img class="img-fluid" src="' + jsonData[i].imgUrl + '"></td>' +
                '<td class="nombreMini ps-3"><strong>' + jsonData[i].nombre + '</strong><button type="button" class="btn-close float-end eliminar"></button></td>' +
                '</tr><tr>' +
                '<td class="medidaMini ps-3"><p class="mb-1">' + jsonData[i].medida + '</p>' + '</td>' +
                '</tr><tr><td class="colorMini ps-3 position-relative">'+
                '<div class="color d-inline-block p-3 me-2" elcolor="' + jsonData[i].color + '" style="background-color:' + jsonData[i].color + '"></div>' +
                '<input type="text" class="cajaCantidad position-absolute" value="' + jsonData[i].cantidad + '">' +
                '</td></tr></table >';

            $(".offcanvas-body").append(listado);
        }    
    }else{
        $(".verCotizacion").addClass("d-none");
    }   
}

