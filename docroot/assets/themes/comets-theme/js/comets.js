(function($){

    $(document).ready(function(){
        var top = $('#main-navigation').offset().top;
        $(window).scroll(function (event) {
            if (window.matchMedia("(min-width: 768px)").matches) {
                if ($('#main-wrap').offset().top + $('#main-wrap').outerHeight() < $(this).scrollTop() + $('#main-navigation').outerHeight()) {
                    $('#main-navigation').css({'position': 'absolute', 'left': 0, 'top': 'auto', 'bottom': 0});
                } else if ($(this).scrollTop() >= top) {
                    $('#main-navigation').css({'position': 'fixed', 'left': $('#main-wrap').offset().left, 'top': (0 - parseFloat($('#main-navigation').css('margin-top').replace(/auto/, 0))), 'bottom': 'auto'});
                } else {
                    $('#main-navigation').css({'position': 'absolute', 'left': 0, 'top': 0, 'bottom': 'auto'});
                }
            }
        });
    });

})(jQuery);