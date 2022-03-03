//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  BOTONES MAS MENOS PARA LA CANTIDAD
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
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
    var datos = $(this).attr("datos").split(",");
    if ($(this).val() == '' || $(this).val() == '0') {
        $(this).val('1');
    }
    datos.push($(this).val());
    addProducto(datos[0], datos[1], datos[2], datos[3], datos[4]);
});
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//Boton de eliminar de la cotización
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$(document).on('click', 'img.del', function () {
    var datos = $(this).attr("datos").split(",");
    //Total de variantes por producto
    eliminaElemento(datos[1], datos[2], datos[3]);

    Id = $(this).parent().parent().attr("id");
    
    //Hay mas de una variante en la cotización
    if ($("#" + datos[0]).children(".medidaMini").length > 0){
        elemento = $(this).parent().index();
        $("#" + datos[0]).children("div:eq(" + (elemento) + ")").remove();
        $("#" + datos[0]).children("div:eq(" + (elemento - 1) + ")").remove();
        $("#" + datos[0]).children("div:eq(" + (elemento - 2) + ")").remove();
        $("#" + datos[0]).children("div:eq(" + (elemento - 3) + ")").remove();
    }

    //Solo hay una variante en la cotización
    if ($("#" + datos[0]).children(".medidaMini").length == 0){
        elemento2 = $("#" + datos[0]).parent().index();
        $("hr."+Id).remove();
        $("div."+Id).remove();
    }


    if($("#contenido div").length == 0){
        $("#contenido").append("<h1 class='text-center'>No hay productos a cotizar</h1>");
        $("#form").hide();
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
//  MUESTRA EL CONTENIDO DE SESION STORAGE POR TIPOS Y CLASIFICA
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
function showStorage(){
    if (sessionStorage.length > 0) {
        var jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
        var caso = 0;
        myArray = [];


        var termino = "no";
        var pos = 0;
        $("#contenido").html("");
        for (i = 0; i < jsonData.length; i++) {
            
            if(myArray.length == 0){
                myArray.push(jsonData[i].nombre);
                caso = 1;
                agregaHTML([caso,jsonData[i].imgUrl,jsonData[i].nombre,jsonData[i].medida,jsonData[i].cantidad,jsonData[i].color]);
                i++;
                if (i == jsonData.length){
                    break;
                }
            }
            do {
                if (myArray[pos] == jsonData[i].nombre){
                    caso = 2;
                    agregaHTML([caso, jsonData[i].medida, jsonData[i].cantidad, jsonData[i].color, jsonData[i].nombre, jsonData[i].imgUrl]);
                    pos=0;
                    termino = "si"; 
                    break;
                }else{
                    if( pos == (myArray.length-1)){
                        myArray.push(jsonData[i].nombre);
                        caso = 1;
                        agregaHTML([caso,jsonData[i].imgUrl,jsonData[i].nombre,jsonData[i].medida,jsonData[i].cantidad,jsonData[i].color]);
                        pos = 0; 
                        termino = "si"; 
                        break;
                    }else{
                        pos++;
                    }
                }
            } while (termino == "si");
        }

        $("#v8").val(arrayContenido);

    }else{
        $("#form").hide();
    }
}

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Agrega Contenido de Sesion Storage a la pagian web
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
let separaciones = 0;
let arrayContenido = [];
function agregaHTML(parametro){
    
    if(parametro[0] == 1){
        arrayContenido.push(parametro[0]+',' +parametro[1] + ',' + parametro[2] + ',' + parametro[3] + ',' + parametro[4] + ',' + parametro[5]+',|'); 
        var n1 = parametro[2].split(" ").join("");
        separaciones == 1 ? h = "<hr class='"+n1+" mt-3'>" : h = "";
        contenido = h + '<div class="'+n1+' col-2 col-lg-4 my-2 text-center">'+
        '<img class="w-100 imagenMini" src="'+parametro[1]+'" alt="">'+
        '</div>'+
        '<div class="'+n1+' nombreMini col-3 col-lg-3 text-center">'+parametro[2]+'</div>'+
        '<div class="'+n1+' col-7 col-lg-5">'+
        '<div id="'+n1+'" class="row fondoGris text-center mb-2 py-2">'+
        '<div class="col-6 col-md-4 medidaMini">'+parametro[3]+'</div>'+
        '<div class="col-6 col-md-4">'+
        '<input type="text" datos="'+parametro[1]+','+parametro[2]+','+parametro[5]+','+parametro[3]+'" class="cajaCantidad" value="'+parametro[4]+'">'+
        '</div>'+
        '<div class="col-6 col-md-2">'+
        '<div class="color d-inline-block p-3 me-2" elcolor="'+parametro[5]+'" style="background-color:'+parametro[5]+'"></div>'+
        '</div>'+
        '<div class="col-6 col-md-2">'+
        '<img class="del" datos="'+n1+','+parametro[3]+','+parametro[5]+','+parametro[2]+'" src="../imgs/icons/trash.jpg" alt="Eliminar">'+
        '</div>'+
        '</div>'+
        '</div>';
        $("#contenido").append(contenido);
    }
    if(parametro[0] == 2){
        arrayContenido.push(parametro[0] + ',' + parametro[1] + ',' + parametro[2] + ',' + parametro[3] + ',' + parametro[4] + ',|'); 
        var n2 = parametro[4].split(" ").join("");
        contenido ='<div class="col-6 col-md-4 medidaMini">'+parametro[1]+'</div>'+
            '<div class="col-6 col-md-4">'+
            '<input type="text" datos="' + parametro[5] + ',' + parametro[4] + ',' + parametro[3] + ',' + parametro[1] +'" class="cajaCantidad" value="'+parametro[2]+'">'+
            '</div>'+
            '<div class="col-6 col-md-2">'+
                '<div class="color d-inline-block p-3 me-2" elcolor="'+parametro[3]+'" style="background-color:'+parametro[3]+'"></div>'+
            '</div>'+
            '<div class="col-6 col-md-2">'+
                '<img class="del" datos="'+n2+','+parametro[1]+','+parametro[3]+','+parametro[4]+'" src="../imgs/icons/trash.jpg" alt="Eliminar">'+
            '</div>';
        $("#"+n2).append(contenido);

    }
    separaciones == 0 ? separaciones = 1 : separaciones = 1;
}

showStorage();