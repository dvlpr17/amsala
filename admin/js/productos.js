

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// PARA DIFERECIAR ENTRE VENTANAS AGREGAR Y MODIFICAR
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
let banderaVentana;
const modProd = document.getElementById('modProd');
const modal = document.getElementById('modal');

modProd.addEventListener('shown.bs.modal', function () {
    banderaVentana = "modProd";
});
modal.addEventListener('shown.bs.modal', function () {
    banderaVentana = "modal";
});

///////////////////////////////////////////////////////////////////////////////////////////
// AGREGAR PRODUCTOS
///////////////////////////////////////////////////////////////////////////////////////////
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Al cerrar la venta incializo los campos
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
modal.addEventListener('hidden.bs.modal', function (event) {
    limpiar()
    $("#form").attr("action", "setProd.php");
    $("#modalTitle strong").text("AGREGAR PRODUCTO");
    // $("#eliminaRegistro").remove();
    // $("#ElID").remove();
});

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Agregar colores
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
losColores = "";
$("#color").on('focusout', function () {
    $(".cajaColores").append('<div class="color btnColor d-inline-block p-3 me-2" elcolor="' + $(this).val() + '" style="background-color:' + $(this).val() + ';"></div>');
    lasComas();
});

$(document).on('click', ".btnColor", function () {
    $(this).remove();
    lasComas();
});

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Validar formulario para agregar
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$("#form").validate({
    submitHandler: function (form) {
        comprobarProducto();
        setTimeout(() => {
            if ($(".estadoUsuario").html().length == 1) {
                document.getElementById("form").submit();
            }
        }, 200);
    },
    rules: {
        nombre: "required"
    },
    messages: {
        nombre: "Completar este campo es obligatorio",
    }
});



///////////////////////////////////////////////////////////////////////////////////////////
// MODIFICAR PRODUCTOS
///////////////////////////////////////////////////////////////////////////////////////////
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Obtiene los datos de la tabla para su edición
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$("#colo").on("focusout", function () {
    // m($(this).val());
    $(".boxColor").append('<div class="color btnColor d-inline-block p-3 me-2" elcolor="' + $(this).val() + '" style="background-color:' + $(this).val() + ';"></div>');
    lasComas();
});

let imgsEnHtml = "";
$(function(){

    // ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    // Muestra en la ventana la información para Editar
    // ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $('#productos tbody').on('click', 'tr', function () {

        $("#respaldoImagenes").val("");
        $("#ElId").val($(this).children("td").eq(0).text());
        $("#n").val($(this).children("td").eq(1).text());
        $("#respaldoNombre").val($(this).children("td").eq(1).text());
        // COMPOSICION
        $("#compo").val($(this).children("td").eq(2).text());
        // COLORES
        $("#modProd").find(".boxColor").html($(this).children("td").eq(3).html());
        $("#modProd").find(".boxColor > .color").addClass("btnColor");
        let RespaldoColores = "";
        for (nc = 0; nc < $(".boxColor > .btnColor").length; nc++) {
            if ($(".boxColor > .btnColor").length > 1) {
                if ($(".boxColor > .btnColor").length == (nc + 1)) {
                    RespaldoColores += $(".boxColor").children(".btnColor").eq(nc).attr("elcolor");
                } else {
                    RespaldoColores += $(".boxColor").children(".btnColor").eq(nc).attr("elcolor") + ",";
                }
            } else {
                RespaldoColores += $(".boxColor").children(".btnColor").eq(nc).attr("elcolor");
            }
        }
        $("#respaldoColores").val(RespaldoColores);
        
        
        reiniciarChecks();
        
        
        // MEDIDAS
        let datos = $(this).children("td").eq(4).text().split(",");
        for (i = 0; i < datos.length; i++) {
            m(datos[i]);
            caja = $("input[value*='" + datos[i] + "']").parent(".modChecks");
            $("input[value*='" + datos[i] + "']").remove();
            caja.prepend('<input class="form-check-input" type="checkbox" value="'+datos[i]+'" name="respaldoMed[]" checked></input>');
        }
        $(".boxColor").prepend(`<p class="form-text">Click para remover</p>`);

        
        // DESCRIPCION
        $("#des").val($(this).children("td").eq(5).text());

        // FOTOS
        $(".detalleFotos").prepend($(this).children("td").eq(6).html());
        imgsEnHtml = $(this).children("td").eq(6).html();
        $(".detalleFotos").prepend(`<p class="form-text">Click para remover</p>`);
        $("#modProd").find(".detalleFotos > img").addClass("removerImagenes");

        //Obtencion de las imgs para comparar con las eliminadas
        let imgsACompararEnBD = "";
        for (nf = 0; nf < $(".detalleFotos > img").length; nf ++) {
            if ($(".detalleFotos > img").length > 1) {
                if ($(".detalleFotos > img").length == (nf + 1)) {
                    imgsACompararEnBD += $(".detalleFotos").children("img").eq(nf).attr("src");
                } else {
                    imgsACompararEnBD += $(".detalleFotos").children("img").eq(nf).attr("src") + ",";
                }
            } else {
                imgsACompararEnBD += $(".detalleFotos").children("img").eq(nf).attr("src");
            }
        }
        $('#imgsAComparar').val(imgsACompararEnBD);
        

        // LA COLECCIÓN
        ElnombreDeLaCarpeta = $(this).children("td").eq(7).text();
        $("#respCole").val(formatoNombreCarpeta(ElnombreDeLaCarpeta));
        // $("#respaldoCole > option").removeAttr("select");

        secundaria = []; principal = '';
        for (let rc = 0; rc < $("#respaldoCole > option").length; rc++) {
            elNombreDeLaColeccion = $("#respaldoCole").children("option").eq(rc).attr("value").split(",");
            conjunto = elNombreDeLaColeccion[0] + "," + elNombreDeLaColeccion[1];
            NombreDeLaCarpeta = $("#respaldoCole").children("option").eq(rc).text();
            if (elNombreDeLaColeccion[1] == $("#respCole").val()){
                principal = '<option value="' + conjunto + '" >' + NombreDeLaCarpeta + '</option>';
            }else{
                secundaria.push('<option value="' + conjunto + '" >' + NombreDeLaCarpeta + '</option>');
            }
        }
        $("#respaldoCole").html("");
        $("#respaldoCole").append(principal);
        for (let no = 0; no < secundaria.length; no++) {        
            $("#respaldoCole").append(secundaria[no]);
        }

        $('#modProd').modal('show');
        
        // REFRESH CHECKBOX MEDIDAS DE LA VENTANA AGREGAR
        const can = $("#modal").find(".form-check").length;
        for (i = 0; i < can; i++) {
            label = $("#modal").find(".form-check").eq(i).children("label").text();
            $("#modal").find(".form-check").eq(i).html('');
            $("#modal").find(".form-check").eq(i).append('<input class="form-check-input" type="checkbox" value="'+label+'" name="medida[]">'+
            '<label class="form-check-label"> '+label+' </label>');
        }    


    });
});


//REMOVER IMAGENES EN LA PARTE DE MODIFICAR
$(document).on('click', ".removerImagenes", function () {

    //ACTUALIZAR LAS FOTOS YA GUARDADAS
    $(".piboteImagenes").html(imgsEnHtml);
    if($(".detalleFotos img").length){
        for (nf = 0; nf < $(".detalleFotos img").length; nf++) {
            // m($(".piboteImagenes").children("img").eq(nf).attr("src"));
            if ($(".piboteImagenes").children("img").eq(nf).attr("src") == $(this).attr("src")) {


                //REGISTRO DE LAS IMAGENES A REMOVER DE LA BD
                let imgsARemover = "";
                if($("#imgsEliminadas").val().length == 0){
                    $("#imgsEliminadas").val($(this).attr("src"));
                }else{
                    imgsARemover = $("#imgsEliminadas").val();
                    imgsARemover += ","+$(this).attr("src");
                    $("#imgsEliminadas").val(imgsARemover);
                }
                
                $(".piboteImagenes").children("img").eq(nf).remove();
                imgsEnHtml = $(".piboteImagenes").html();
            }
        }
    }
    $(".piboteImagenes").html("");
    $(".detalleFotos").html("");
    $(".detalleFotos").html(imgsEnHtml);
    $("#modProd").find(".detalleFotos > img").addClass("removerImagenes");
    
    $("#respaldoImagenes").val("");
    $(this).remove();

});

///////////////////////////////////////////////////////////////////////////////////////////
// ELIMINAR PRODUCTOS
///////////////////////////////////////////////////////////////////////////////////////////
$("#EliminarProducto").on("click", function(){
    $("#modProd").modal("hide");
    $("#EliminarRegistro").modal("show");
});



$("#confirmado").on("click", function(){
    // m($("#ElId").val());
    $.ajax({
        dataType: "html",
        type: "POST",
        url: 'delProd.php',
        data: { "prodAEliminar": $("#ElId").val(), "imagenes": $("#imgsAComparar").val() },
        success: function (datos) {
            // m(datos);
            window.location = "admin.php";
        }
    });
});

///////////////////////////////////////////////////////////////////////////////////////////
//LAS COLECCIONES
///////////////////////////////////////////////////////////////////////////////////////////
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Agregar Colección
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

$("#coleAgr").on('click',function(){

    comprobarColeccion();
    setTimeout(() => {
        if($(".estadoColeccion").html().length == 1){
            $.ajax({
                dataType: "html",
                type: "POST",
                url: 'setCole.php',
                data: { "valor": $("#nombreColeccion").val()},
                success: function (datos) {
                    $("#nombreColeccion").val("");
                    $("#AgregarColeccion").modal("hide");
                    window.location = "admin.php";
                }
            });
        } 
        if ($(".estadoColeccion").html().length == 0) {
            $(".estadoColeccion").html("<span class='text-danger'>Campo vacio</span>");
        }
    }, 200);

});

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Actualizar Colección
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$("#coleAct").on('click',function(){
    if ($("#lasColecciones").has('option').length > 0 ) {


        
        let coleccionAnterior = formatoNombreCarpeta($("#LaColeccionAnterior option:selected").text());
        let coleccionNueva = formatoNombreCarpeta($("#remplazar").val());


        $.ajax({
            dataType: "html",
            type: "POST",
            url: 'updateCole.php',
            data: { "id": $("#LaColeccionAnterior").val(), "laNueva": $("#remplazar").val(), "laAnterior": coleccionAnterior },
            success: function () {
                // $("#AgregarColeccion").modal("hide");
                // $("#remplazar").val("");
                window.location = "admin.php"; 
            }
        });


    }else{
        $(".estadoActualizar").html("<span class='text-danger'>Selecciona una opción</span>");
    }
});

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// ELIMINAR COLECCIÓN
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
$("#colElim").on('click',function(){
    if ($("#eliminaCole").has('option').length > 0 ) {
        $.ajax({
            dataType: "html",
            type: "POST",
            url: 'delCole.php',
            data: { "id": $("#eliminaCole").val() },
            success: function (datos) {
                window.location = "admin.php";
            }
        });

    }else{
        $(".estadoEliminar").html("<span class='text-danger'>Selecciona una opción</span>");
    }
});



    

///////////////////////////////////////////////////////////////////////////////////////////
// HELPERS
///////////////////////////////////////////////////////////////////////////////////////////

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Función para las salidas de consola
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
function m(msg) { console.log(msg); }

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Comprobar si el producto ya existe
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

function comprobarProducto() {
    $.ajax({
        dataType: "html",
        type: "POST",
        url: 'searchDuplicate.php',
        data: { "variable": $("#nombre").val(), "tipo": "producto" },
        success: function (datos) {
            $(".estadoUsuario").html(datos);
        }
    });
}

const compruebaProd = (obj) =>{
    if ($(obj).val().toUpperCase() != $("#respaldoNombre").val().toUpperCase()){
        $.ajax({
            dataType: "html",
            type: "POST",
            url: 'searchDuplicate.php',
            data: { "variable": $(obj).val(), "tipo": "producto" },
            success: function (datos) {
                $(".estadoProd").html(datos);
            }
        });
    }else{
        $(".estadoProd").html("");
    }
}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Comprobar si la coleccion ya existe
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
function comprobarColeccion() {
    valor = "";
    var estado;
    $(".estadoColeccion").html("");
    $(".estadoRemplazo").html("");

    if ($("#remplazar").val() != "") {
        valor = $("#remplazar").val();
        estado = $(".estadoRemplazo");
    }
    if ($("#nombreColeccion").val() != "") {
        valor = $("#nombreColeccion").val();
        estado = $(".estadoColeccion");
    }


    if (valor != "") {
        $.ajax({
            dataType: "html",
            type: "POST",
            url: 'searchDuplicate.php',
            data: { "variable": valor, "tipo": "coleccion" },
            success: function (datos) {
                estado.html(datos);
            }
        });
    }
}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// Limpiar formulario de registro
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

function limpiar() {
    // caja = 1;
    document.getElementById("form").reset();
    $(".cajaColores").html("");
    $(".cajaColores").html('<p class="form-text">Click en el cuadro de color para remover</p>');
}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// ELIMINA LAS COMAS
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

const lasComas = () => {

    if (banderaVentana == "modal"){
        contenedorDeColores = $(".cajaColores");
        contenedorDeHexadecimal = $(".losColores");
    }
    if (banderaVentana == "modProd"){
        contenedorDeColores = $(".boxColor");
        contenedorDeHexadecimal = $(".respaldoColores");
    }

    losColores = "";
    orale = contenedorDeColores.children("div").length;
    
    // revisar las comas
    for (i = 0; i < orale; i++) {
        if (orale < 2) {
            comas = "";
        } if (orale > 1) {
            if (i == (orale - 1)) {
                comas = "";
            } else {
                comas = ",";
            }
        }
        losColores += contenedorDeColores.children("div").eq(i).attr("elcolor") + comas;
    }
    contenedorDeHexadecimal.val(losColores);
    
}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// REINICIA LOS CHECKS EN LA PARTE DE MODIFICAR
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

const reiniciarChecks = () =>{
    $(".check1").html("");
    $(".check2").html("");
    $(".check3").html("");
    $(".check4").html("");
    $(".detalleFotos").html("");

    $(".check1").append('<div class="form-check modChecks"><input class="form-check-input" type="checkbox" value="45 x 45 cm" name="respaldoMed[]" >'+
    '<label class="form-check-label" for="flexCheckDefault"> 45 x 45 cm </label></div>'+
    '<div class="form-check modChecks"><input class="form-check-input" type="checkbox" value="55 x 35 cm" name="respaldoMed[]">'+
    '<label class="form-check-label" for="flexCheckChecked"> 55 x 35 cm </label></div> ');
    
    $(".check2").append('<div class="form-check modChecks"><input class="form-check-input" type="checkbox" value="50 x 50 cm" name="respaldoMed[]">'+
    '<label class="form-check-label" for="flexCheckDefault"> 50 x 50 cm </label></div >'+
    '<div class="form-check modChecks"><input class="form-check-input" type="checkbox" value="60 x 60 cm" name="respaldoMed[]">'+
    '<label class="form-check-label" for="flexCheckChecked"> 60 x 60 cm </label></div>');
    
    $(".check3").append('<div class="form-check modChecks"><input class="form-check-input" type="checkbox" value="Individual" name="respaldoMed[]" >'+
        '<label class="form-check-label"> Individual</label></div><div class="form-check modChecks">'+
        '<input class="form-check-input" type="checkbox" value="Matrimonial" name="respaldoMed[]"><label class="form-check-label"> Matrimonial</label></div>');

    $(".check4").append('<div class="form-check modChecks"><input class= "form-check-input" type = "checkbox" value = "King Size" name = "respaldoMed[]" >'+
        '<label class="form-check-label"> King Size</label></div >');

}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// GENERA UN PREVIEW DE LAS IMAGENES EN LA SECCIÓN DE MODIFICAR
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

function previewFiles() {

    //LIMPIAR CONTENEDOR DE THUMSNAILS
    $(".detalleFotos").html(imgsEnHtml);
    $("#modProd").find(".detalleFotos > img").addClass("removerImagenes");
    
    //CARGAR FOTOS NUEVAS
    var preview = document.querySelector('.detalleFotos');
    var files = document.getElementById('respaldoImagenes').files;

    function readAndPreview(file) {
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                var image = new Image();
                image.width = 50;
                image.title = file.name;
                image.src = this.result;
                image.className = "img-thumbnail removerImagenes";
                preview.appendChild(image);
            }, false);
            reader.readAsDataURL(file);
        }
    }
    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// ADAPTACIÓN PARA EL NOMBRE DE LA CARPETA
// ~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

const formatoNombreCarpeta = (nombre) =>{

    let minusculas = nombre.toLowerCase();
    let espacios = minusculas.replace(/ /g, "");
    return espacios;

}