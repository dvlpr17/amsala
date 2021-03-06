let porcentage = "30%"
const m = mnsg => console.log(mnsg);

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/* Open when someone clicks on the span element */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
function openNav() {
    wresize();
    document.getElementById("myNav").style.width = porcentage;
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/* Close when someone clicks on the "x" symbol inside the overlay */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
//  ANCHO DE VENTANA
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
const wresize = () => {
    window.addEventListener('resize', function () {
        if (window.innerWidth <= 1079) {
            porcentage = "70%";
        } else if (window.innerWidth >= 1079) {
            porcentage = "30%";
        }
    }, true);
    if (window.innerWidth <= 1079) {
        porcentage = "70%";
    } else if (window.innerWidth >= 1079) {
        porcentage = "30%";
    }
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
//INICIALIZAR ANIMACIONES
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
AOS.init();


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
// HEADER STICKY WITH SCROLL
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
EstamosEn = $("title").text().split("AMSALA | ");

window.onscroll = function () { menuSticky() };

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;
var altura = 400;
var anchoVentana;


if(EstamosEn[1] == "Contacto"){
    altura = 150;
}
if (EstamosEn[1] == "Cotizar"){
    altura = 0;
    // fixedDetalle
}

function menuSticky() {
    
    //ESTO ES PARA EL MENU
    if (window.pageYOffset > altura) {
        header.classList.add("sticky");
        header.classList.remove("py-5");
        header.classList.add("py-3");
        $("body").css("padding-top","160px");
    } else {
        header.classList.add("py-5");
        header.classList.remove("py-3");
        header.classList.remove("sticky");
        $("body").css("padding-top","0px");
    }


    //https://www.w3schools.com/jsref/prop_win_pagexoffset.asp
    if(EstamosEn[1] == "Cotizar"){
        //SI ESTAS EN MOVIL DESACTIVAR LA INTERACCI??N DEL SCROLL
        if (anchoVentana >= 975){

            // AJUSTE PARA QUE LA INFORMACI??N DEL PRODUCTO SIGA EL SCROLL
            if (document.getElementById('ver').getBoundingClientRect().bottom < document.documentElement.clientHeight) {
                $("#LaInformacion").addClass("fixedDetalle");
                $("#LaInformacion").removeClass("DetalleAbajo");
                $("#LaInfo").removeClass("posicionarAbajo");
            }
            if (document.getElementById('LasFotos').getBoundingClientRect().bottom > 0 && document.getElementById('LasFotos').getBoundingClientRect().bottom < document.documentElement.clientHeight){
                $("#LaInformacion").removeClass("fixedDetalle");
                $("#LaInformacion").addClass("DetalleAbajo");
                $("#LaInfo").addClass("posicionarAbajo");
            }
            if (document.getElementById('LasFotos').getBoundingClientRect().top > 0 && document.getElementById('LasFotos').getBoundingClientRect().top < document.documentElement.clientHeight){
                $("#LaInformacion").removeClass("fixedDetalle");
                $("#LaInformacion").removeClass("DetalleAbajo");
                $("#LaInfo").removeClass("posicionarAbajo");
            }
        }else{
            $("#LaInformacion").removeClass("fixedDetalle");
            $("#LaInformacion").removeClass("DetalleAbajo");
            $("#LaInfo").removeClass("posicionarAbajo");

        }

    }
}


$(window).resize(function () {
    anchoVentana = $(window).width();
});

$(window).resize();


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
// FORMULARIO DE CONTACTO
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict'
    
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.querySelectorAll('.needs-validation')

// Loop over them and prevent submission
Array.prototype.slice.call(forms)
    .forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
        }

        form.classList.add('was-validated')
    }, false)
    })
})()    