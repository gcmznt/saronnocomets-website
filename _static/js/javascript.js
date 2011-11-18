var globalContainer;
var allPages;
var scrollableAPI;
var menuHeight;
var wind = $(window);
var scrollTimer;
var currentPage;
var pageLoaded = [];

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
            pageLoaded.push($(this).attr('href'));
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
        touch: false,
        onBeforeSeek: function(event, index) {
            if (index < this.getSize()) {
                allPages.css('overflow', 'hidden');
                var dest = $('#menu a').eq(index);
                var left = dest.position().left + parseInt(dest.css('margin-left'));
                var width = dest.outerWidth();
                var perc = index / this.getSize() * 20;
                $('#pageCursor').animate({left: left, width: width});
                $('body').animate({backgroundPosition: -perc+'% 0'});

                if (jQuery.inArray(dest.attr('href'), pageLoaded) == -1) {
                    $.get(dest.attr('href')+'.php', function(data) {
                        $('#'+dest.attr('href')+' .innerContainer').html(data);
                        $('#'+dest.attr('href')+' .innerContainer').find('div[title]:first').addClass('active');
                        createMenu($('#'+dest.attr('href')));
                        pageLoaded.push(dest.attr('href'));
                        resizeViewport();
                    });
                }
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



    createMenu(currentPage);


    $('.innerMenu a').live('click', function(event) {
        var currentLink = $(this);
        goTo(currentLink.attr('href'));
        return false;
    });
    $('.innerMenu a').live('mouseenter',function() {
        $(this).animate({'margin-right':'10px'},{duration:100,queue:false});
    }).live('mouseleave', function() {
        $(this).animate({'margin-right':'0px'},{duration:100,queue:false});
    });

    allPages.scroll(function() {
        var cutoff = currentPage.scrollTop();
        currentPage.find('.innerMenu').animate({top:cutoff},{duration:200,queue:false},'easeOutCirc');
        var pageLinks = currentPage.find('div[title]');
        pageLinks.each(function() {
            var currentLink = $(this);
            if (currentLink.position().top >= cutoff) {
                pageLinks.removeClass('active');
                currentLink.addClass('active');
                currentPage.find('.innerMenu a').removeClass('active');
                currentPage.find('.innerMenu a[href=#'+$(this).attr('id')+']').addClass('active');
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













    // $.get('p1.php', function(data) {
    //     $('#p1 .innerContainer').html(data);
    //     $('#p1 .innerContainer').find('div[title]:first').addClass('active');
    // });

    // $.get('p3.php', function(data) {
    //     $('#p3 .innerContainer').html(data);
    //     $('#p3 .innerContainer').find('div[title]:first').addClass('active');
    // });

    // $.get('p4.php', function(data) {
    //     $('#p4 .innerContainer').html(data);
    //     $('#p4 .innerContainer').find('div[title]:first').addClass('active');
    // });

    $('#p2 .innerContainer').find('div[title]:first').addClass('active');
    
    
});

function goTo(id) {
    var anchor = $('div[id='+id.substring(1)+']');
    anchor.parents('.page').animate({scrollTop:anchor.position().top}, 'slow');    
}

function resizeViewport() {
    globalContainer.css('height', wind.height()/*-menuHeight*/);
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

function createMenu(page) {
    var menu = $('<ul class="innerMenu"></ul>');
    var current = page.find('.innerContainer');
    var pageId = page.attr('id');
    current.children('div[title]').each(function(index) {
        var linkName = $(this).attr('title');
        var linkId = 'page'+pageId+'-content'+index;
        $(this).attr('id', linkId)
        var item = $('<li><a href="#'+linkId+'">'+linkName+'</a></li>');
        item.appendTo(menu);
    });
    menu.find('li:first a').addClass('active');
    current.prepend(menu);
}
