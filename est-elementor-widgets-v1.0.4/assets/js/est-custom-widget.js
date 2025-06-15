jQuery(document).ready(function($){
    
    // Elementor module: Single image links to products: tooltip

    $('.est-btn-tooltip').on({
        mouseenter: function() {
            $(this).children(":first").removeClass("small");
        },
        mouseleave: function() {
            if(!$(this).next().hasClass("show-tooltip")){
                $(this).children(":first").addClass("small");
            }        
        },
        click: function(e) {
            e.stopPropagation();
            $(this).next().toggleClass("show-tooltip");
            $(this).children(":first").removeClass("small");
            if( $(this).next().hasClass('show-tooltip') ){
                $(this).find('.icon-up').hide();
                $(this).find('.icon-down').show();
            }else{
                $(this).find('.icon-up').show();
                $(this).find('.icon-down').hide();                
            }
        }
    });

    $('body').click( function(e) {
        $('.est-btn-tooltip').each(function(){
            $(this).next().removeClass("show-tooltip");
            $(this).children(":first").addClass("small");
            $(this).find('.icon-up').show();
            $(this).find('.icon-down').hide();
        });
    });

});  