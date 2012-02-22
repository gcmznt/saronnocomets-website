function changeHero(heroIn) {
    var heroOut = $('.hero:visible');
    if (!heroIn) {
        if (heroOut.next('.hero').length)
            heroIn = heroOut.next();
        else
            heroIn = $('.hero').first();
    }
    heroIn.css({left:'-3000px',top:'0px'}).show().animate({left:'0px'}, 700);
    heroOut.animate({top:'-500px'}, 300, function(){
        $(this).hide()
        $('#heroNavi .active').removeClass('active');
        $('#heroNavi a').eq(heroIn.index()).addClass('active');
    });
}

function heroTimer() {
    changeHero();
    t = setTimeout(heroTimer, heroInterval);
}

var heroInterval = 12000;
var t;

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
            changeHero($('.hero').eq($(this).index()));
            clearTimeout(t);
            t = setTimeout(heroTimer, heroInterval);
        });
    }
    $('.prettyPhoto').prettyPhoto({
        deeplinking: false,
        social_tools: ''
    });
});