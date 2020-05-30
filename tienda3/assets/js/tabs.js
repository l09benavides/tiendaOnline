/***************************/
//@Author: Adrian Mato Gondelle
//@website: http://web.ontuts.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
    $(".men > li").click(function(e){
        var a = e.target.id;
        //desactivamos seccion y activamos elemento de menu
        $(".men li.active").removeClass("active");
        $(".men #"+a).addClass("active");
        //ocultamos divisiones, mostramos la seleccionada
        $(".content").css("display", "none");
		$(".contenedor_invisible").css("display", "none");
        $("."+a).fadeIn();
    });
});

$(document).ready(function(){
    $(".mene > li").click(function(e){
        var a = e.target.id;
        //desactivamos seccion y activamos elemento de menu
        $(".mene li.active").removeClass("active");
        $(".mene #"+a).addClass("active");
        //ocultamos divisiones, mostramos la seleccionada
        $(".content2").css("display", "none");
		$(".contenedor_invisible2").css("display", "none");
        $("."+a).fadeIn();
    });
});

$(document).ready(function(){
    $(".menese > li").click(function(e){
        var a = e.target.id;
        //desactivamos seccion y activamos elemento de menu
        $(".menese li.active").removeClass("active");
        $(".menese #"+a).addClass("active");
        //ocultamos divisiones, mostramos la seleccionada
        $(".content3").css("display", "none");
		$(".contenedor_invisible3").css("display", "none");
        $("."+a).fadeIn();
    });
});