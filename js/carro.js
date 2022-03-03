

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//  FUNCION PARA ELIMINAR ELEMENTOS DE SESION STORAGE
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

function eliminaElemento(Medida, Color, Nombre){

    var jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
    var cadenaDatos = '[', res = "";

    for (var i = 0; i < jsonData.length; i++) {
        if (jsonData[i].nombre === Nombre && jsonData[i].color === Color && jsonData[i].medida === Medida) {
            // m("Eliminado: " + jsonData[i].medida);
        }else{
            cadenaDatos += '{"imgUrl":"' + jsonData[i].imgUrl + '","nombre":"' + jsonData[i].nombre + '","color":"' + jsonData[i].color + '","medida":"' + jsonData[i].medida + '","cantidad":' + jsonData[i].cantidad + '}';
        }
    }
    cadenaDatos += ']';
    res = cadenaDatos.replaceAll("}{", "},{");
    sessionStorage.setItem("PRODUCTOS", res);
    jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
    if (jsonData.length == 0) {
        sessionStorage.clear();
    }

}


//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
//    FUNCION PARA REMPLAZAR CARACTERES EN STRINGS
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};



//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~
//    FUNCION PARA AGREGAR ELEMENTOS A SESSION STORAGE
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~
function addProducto(laUrl, Nombre, Color, Medida, Cantidad) {

    var contenido, datos, duplicado = "";
    if(laUrl != undefined){
        
        if (sessionStorage.length == 0) {
            contenido = '[';
        } else if (sessionStorage.length > 0) {
            var jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
            
            for (var i = 0; i < jsonData.length; i++) {
                if (jsonData[i].nombre === Nombre && jsonData[i].color === Color && jsonData[i].medida === Medida) {
                    duplicado = "si";
                    
                    jsonData[i].cantidad = parseInt(Cantidad);
                    sessionStorage.setItem("PRODUCTOS", JSON.stringify(jsonData));
                    break;
                }
            }
            
            if (duplicado == "") {
                contenido = sessionStorage.getItem("PRODUCTOS").split("]")[0] + ",";
            }
        }
        
        if (duplicado == "") {
            datos = '{"imgUrl":"' + laUrl + '","nombre":"' + Nombre + '","color":"' + Color + '","medida":"' + Medida + '","cantidad":' + Cantidad + '}';
            contenido = contenido + datos + ']';
            sessionStorage.setItem("PRODUCTOS", contenido);
        }

        // m("Longitud del session Storage "+sessionStorage.length+"\n");
        // m("Nombre de la Session "+sessionStorage.key(0)+"\n");
        // m("Contenido de la Session " + sessionStorage.getItem("PRODUCTOS"));

        if (sessionStorage.length > 0){
            jsonData = JSON.parse(sessionStorage.getItem("PRODUCTOS"));
        }
    }
}




