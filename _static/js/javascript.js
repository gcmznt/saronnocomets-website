function changeHero(heroIn) {
    if (!lock) {
        lock = true;
        var heroOut = $('.hero:visible');
        if (!heroIn) {
            if (heroOut.next('.hero').length)
                heroIn = heroOut.next();
            else
                heroIn = $('.hero').first();
        }
        heroOut.animate({top:'-200px',opacity:'0'}, 300, function(){
            $(this).hide()
            $('#heroNavi .active').removeClass('active');
            $('#heroNavi a').eq(heroIn.index()).addClass('active');
        });
        heroIn.css({left:'800px',top:'0px',opacity:'0'}).show().animate({left:'0px',opacity:'1'}, 700, function() {
            lock = false;
        });
        heroIn.find('h2').css({'margin-left':'-1600px',opacity:'0'}).animate({'margin-left':'0px',opacity:'1'}, 700);
        heroIn.find('h3').css({'margin-left':'-2000px',opacity:'0'}).animate({'margin-left':'0px',opacity:'1'}, 800);
        heroIn.find('a').css({'margin-left':'-2400px',opacity:'0'}).animate({'margin-left':'0px',opacity:'1'}, 900);
    }
}

function heroTimer() {
    clearTimeout(t);
    changeHero();
    t = setTimeout(heroTimer, heroInterval);
}

var heroInterval = 12000;
var t;
var lock = false;

$(document).ready(function() {
    var l = $('.hero').length;
    if (l > 1) {
        t = setTimeout(heroTimer, heroInterval);
        var navi = $('<div id="heroNavi"></div>');
        for (var i = 0; i < l; i++) {
            active = ($('.hero:visible').index() == i) ? ' class="active"' : '';
            navi.append('<a'+active+'>'+(i+1)+'</a>');
        }
        $('#herospace').append(navi);
        $('#herospace').hover(function() {
            clearTimeout(t);
        }, function() {
            t = setTimeout(heroTimer, heroInterval);
        });
        $('#heroNavi a').click(function() {
            if (!$(this).hasClass('active')) {
                clearTimeout(t);
                changeHero($('.hero').eq($(this).index()));
                t = setTimeout(heroTimer, heroInterval);
            }
        });
    }

    $('.newsContent img').parents('a').attr('rel','prettyPhoto[news]').addClass('prettyPhoto');
    $('.prettyPhoto').prettyPhoto({
        deeplinking: false,
        social_tools: ''
    });
    $('.prettyPhotoIframe').prettyPhoto({
        deeplinking: false,
        social_tools: '',
        default_width: 960,
        default_height: 500
    });

});



$(function() {
    var top = $('nav').offset().top - parseFloat($('nav').css('margin-top').replace(/auto/, 0));
    $(window).scroll(function (event) {
      // what the y position of the scroll is
      var y = $(this).scrollTop();
      
      // whether that's below the form
      if (y >= top) {
        // if so, ad the fixed class
        $('nav').css('position', 'fixed');
        $('section').css('margin-left', '230px');
      } else {
        // otherwise remove it
        $('nav').css('position', 'static');
        $('section').css('margin-left', '30px');
      }
    });
});
