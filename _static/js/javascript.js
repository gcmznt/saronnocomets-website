var globalContainer;
var allPages;
var scrollableAPI;
var menuHeight;
var wind = $(window);
var scrollTimer;
var currentPage;

$(document).ready(function() {

    globalContainer = $('#container');
    allPages = $('.page');
    menuHeight = $('#menu').height();

    globalContainer.scrollable({
        items: '.pages',
        onSeek: function() { currentPage = $('.page').eq(scrollableAPI.getIndex()); }
    });
    scrollableAPI = globalContainer.data('scrollable');

    resizeViewport();
    $(window).resize(function() {
        resizeViewport();
    });

    $('.innerContainer').each(function() {
        var menu = $('<ul class="innerMenu"></ul>');
        var current = $(this);
        current.find('a[name]').each(function() {
            var linkName = $(this).attr('name');
            var item = $('<li><a href="#'+linkName+'">'+linkName+'</a></li>');
            item.appendTo(menu);
        });
        current.prepend(menu);
    });
    $('.innerMenu').each(function() {
        $(this).find('li:first a').addClass('active')
    });

    $('.innerMenu a').live('click', function(event) {
        var currentLink = $(this);
        goTo(currentLink.attr('href'));
        return false;
    });

    allPages.scroll(function() {
        var cutoff = currentPage.scrollTop();
        currentPage.find('.innerMenu').animate({top:cutoff},{duration:500,queue:false});
        var pageLinks = currentPage.find('a[name]');
        pageLinks.each(function() {
            var currentLink = $(this);
            if (currentLink.position().top >= cutoff) {
                pageLinks.removeClass('active');
                currentLink.addClass('active');
                currentPage.find('.innerMenu a').removeClass('active');
                currentPage.find('.innerMenu a[href=#'+$(this).attr('name')+']').addClass('active');
                return false;
            }
        });
    });

    $('#menu a').click(function() {
        var index = $(this).parent().index();
        scrollableAPI.seekTo(index, 400);
        return false;
    });
    
});

function goTo(id) {
    var anchor = $('a[name='+id.substring(1)+']');
    anchor.parents('.page').animate({scrollTop:anchor.position().top}, 'slow');    
}

function resizeViewport() {
    globalContainer.css('height', wind.height()-menuHeight);
    allPages.css('width', wind.width());
    allPages.css('height', globalContainer.height());
    scrollableAPI.seekTo(scrollableAPI.getIndex(), 0);
    allPages.each(function() {
        console.log();
        h1 = $(this).children('.innerContainer').height();
        h2 = $(this).find('a[name]:last').position().top;
        h3 = $(this).height();
        p = h3 - (h1 - h2)
        $(this).children('.innerContainer').css('padding-bottom', p+'px');
    });
}

