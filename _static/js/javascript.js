var globalContainer;
var allPages;
var scrollableAPI;
var menuHeight;
var wind = $(window);
var scrollTimer;
var currentPage;

$(document).ready(function() {

    $('#menuContainer').append('<div id="pageCursor"></div>');
    var dest = $('#menu a.active');
    var left = dest.position().left + parseInt(dest.css('margin-left'));
    var width = dest.outerWidth();
    $('#pageCursor').css({left: left, width: width});

    var pages = $('<div id="pages"></div>')
    $('#menu a').each(function() {
        if ($(this).hasClass('active')) {
            var current = $('#container .page');
            current.attr('id', $(this).attr('href'));
            pages.append(current);
            currentPage = current;
        } else {
            pages.append('<div class="page" id="'+$(this).attr('href')+'"><div class="innerContainer"></div></div>');
        }
    });
    pages.appendTo('#container');


    globalContainer = $('#container');
    allPages = $('.page');
    menuHeight = $('#menu').height();

    globalContainer.scrollable({
        items: '#pages',
        onBeforeSeek: function(event, index) {
            if (index < this.getSize()) {
                allPages.css('overflow', 'hidden');
                var dest = $('#menu a').eq(index);
                var left = dest.position().left + parseInt(dest.css('margin-left'));
                var width = dest.outerWidth();
                var perc = index / this.getSize() *100;
                $('#pageCursor').animate({left: left, width: width});
            }
        },
        onSeek: function() {
            allPages.css('overflow', 'auto');
            currentPage = $('.page').eq(this.getIndex());
            $('#menu a.active').removeClass('active');
            $('#menu li').eq(this.getIndex()).find('a').addClass('active');
        }
    });
    scrollableAPI = globalContainer.data('scrollable');
    scrollableAPI.seekTo(currentPage.index(),0);

    resizeViewport();
    $(window).resize(function() {
        resizeViewport();
    });



    // $('.innerContainer').each(function() {
    //     var menu = $('<ul class="innerMenu"></ul>');
    //     var current = $(this);
    //     current.find('div[title]').each(function() {
    //         var linkName = $(this).attr('title');
    //         var item = $('<li><a href="'+linkName+'">'+linkName+'</a></li>');
    //         item.appendTo(menu);
    //     });
    //     current.prepend(menu);
    // });
    // $('.innerMenu').each(function() {
    //     $(this).find('li:first a').addClass('active')
    // });

    // $('.innerMenu a').live('click', function(event) {
    //     var currentLink = $(this);
    //     goTo(currentLink.attr('href'));
    //     return false;
    // });

    allPages.scroll(function() {
        var cutoff = currentPage.scrollTop();
        // currentPage.find('.innerMenu').css('top', cutoff);
        // currentPage.find('.innerMenu').animate({top:cutoff},{duration:500,queue:false});
        var pageLinks = currentPage.find('div[title]');
        pageLinks.each(function() {
            var currentLink = $(this);
            if (currentLink.position().top >= cutoff) {
                pageLinks.removeClass('active');
                currentLink.addClass('active');
                // currentPage.find('.innerMenu a').removeClass('active');
                // currentPage.find('.innerMenu a[href=#'+$(this).attr('name')+']').addClass('active');
                return false;
            }
        });
    });

    $('#menu a').click(function() {
        var index = $(this).parent().index();
        if (index != scrollableAPI.getIndex())
            scrollableAPI.seekTo(index, 400);
        return false;
    });













    $.get('p1.php', function(data) {
        $('#p1 .innerContainer').html(data);
        $('#p1 .innerContainer').find('div[title]:first').addClass('active');
        resizeViewport();
    });

    $.get('p3.php', function(data) {
        $('#p3 .innerContainer').html(data);
        $('#p3 .innerContainer').find('div[title]:first').addClass('active');
        resizeViewport();
    });

    $.get('p4.php', function(data) {
        $('#p4 .innerContainer').html(data);
        $('#p4 .innerContainer').find('div[title]:first').addClass('active');
        resizeViewport();
    });

    $('.innerContainer').each(function() {
        $(this).find('div[title]:first').addClass('active');
    });
    
});

// function goTo(id) {
//     var anchor = $('div[title='+id.substring(1)+']');
//     anchor.parents('.page').animate({scrollTop:anchor.position().top}, 'slow');    
// }

function resizeViewport() {
    globalContainer.css('height', wind.height()-menuHeight);
    allPages.css('width', wind.width());
    allPages.css('height', globalContainer.height());
    scrollableAPI.seekTo(scrollableAPI.getIndex(), 0);
    allPages.each(function() {
        h1 = $(this).children('.innerContainer').height();
        if (h1 > 0) {
            h2 = $(this).find('div[title]:last').position().top;
            h3 = $(this).height();
            p = h3 - (h1 - h2)
            $(this).children('.innerContainer').css('padding-bottom', p+'px');
        }
    });
}

