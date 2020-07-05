(function($){$(function(){
    
    $('[data-type=number]').keypress( function(ev) {
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault(); //stop character from entering input
       }
    });
    
    $('[data-mask]').each(function() {
        var mask = $(this).attr('data-mask');
        //alert(mask);
        $(this).mask(mask);
    });
        
});})(jQuery);
    
