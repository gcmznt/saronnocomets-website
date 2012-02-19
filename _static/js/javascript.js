function changeHero() {
	var heroOut = $('.hero:visible');
	if (heroOut.next().length)
		var heroIn = heroOut.next();
	else
		var heroIn = $('.hero').first();
	heroIn.css({left:'-3000px',top:'0px'}).show().animate({left:'0px'}, 700);
	heroOut.animate({top:'-500px'}, 300, function(){$(this).hide()});
}

function heroTimer() {
	changeHero();
	t = setTimeout(heroTimer, heroInterval);
}

var heroInterval = 12000;

$(document).ready(function() {
	if ($('.hero').length > 1)
		var t = setTimeout(heroTimer, heroInterval);
});