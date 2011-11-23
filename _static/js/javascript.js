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
            currentPage.find('div[title]:first').addClass('active');
        } else {
            pages.append('<div class="page" id="'+$(this).attr('href')+'"><div class="innerContainer loading"></div></div>');
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
                var perc = index / this.getSize() * 10;
                $('#pageCursor').animate({left: left, width: width});
                $('body').animate({backgroundPosition: perc+'% 0'});
                $('#menu a.active').removeClass('active');

                if (jQuery.inArray(dest.attr('href'), pageLoaded) == -1) {
                    $.get('_includes/pages/'+dest.attr('href')+'.php', function(data) {
                        $('#'+dest.attr('href')+' .innerContainer').removeClass('loading').html(data);
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
            $('#menu li').eq(this.getIndex()).find('a').addClass('active');
        }
    });
    scrollableAPI = globalContainer.data('scrollable');
    perc = currentPage.index() / scrollableAPI.getSize() * 10;
    $('body').css({backgroundPosition: perc+'% 0'});
    scrollableAPI.seekTo(currentPage.index(),0);

    resizeViewport();
    $(window).resize(function() {
        resizeViewport();
    });



    createMenu(currentPage);


    $('.innerMenu a').live('click', function(event) {
        var currentLink = $(this);
        goTo(currentLink.attr('href').substring(1));
        return false;
    });
    $('.innerMenu a').live('mouseenter',function() {
        $(this).animate({'margin-right':'-10px'},{duration:100,queue:false});
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







    $(document).bind('keydown', function(data) {
        /* su e pgsu */
        if(data.keyCode == 38 || data.keyCode == 33) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); $('#navigator .uarr').addClass('active'); return false; }
        /* giu e pggiu */
        if(data.keyCode == 40 || data.keyCode == 34) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); $('#navigator .darr').addClass('active'); return false; }
        /* fine */
        if(data.keyCode == 35) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); return false; }
        /* inizio */
        if(data.keyCode == 36) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); return false; }
        /* destra */
        if(data.keyCode == 39) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); $('#navigator .rarr').addClass('active'); return false; }
        /* sinistra */
        if(data.keyCode == 37) { $('#navigatorContainer .baloon').clearQueue().fadeOut(); $('#navigator .larr').addClass('active'); return false; }
    });

    $(document).bind('keyup', function(data) {
        /* su e pgsu */
        if(data.keyCode == 38 || data.keyCode == 33) { $('#navigator .uarr').removeClass('active'); goUp(); return false; }
        /* giu e pggiu */
        if(data.keyCode == 40 || data.keyCode == 34) { $('#navigator .darr').removeClass('active'); goDown(); return false; }
        /* fine */
        if(data.keyCode == 35) { goEnd(); return false; }
        /* inizio */
        if(data.keyCode == 36) { goTop(); return false; }
        /* destra */
        if(data.keyCode == 39) { $('#navigator .rarr').removeClass('active'); return false; }
        /* sinistra */
        if(data.keyCode == 37) { $('#navigator .larr').removeClass('active'); return false; }
    });


    $('#navigator a').live('click', function(event) {
        /* su */
        if($(this).attr('href') == '#up') { goUp(); return false; }
        /* giu */
        if($(this).attr('href') == '#down') { goDown(); return false; }
        /* avanti */
        if($(this).attr('href') == '#next') { scrollableAPI.next(); return false; }
        /* indietro */
        if($(this).attr('href') == '#prev') { scrollableAPI.prev(); return false; }
    });


    $('body').append('<div id="navigatorContainer"><div class="baloon">Naviga con la tua tastiera!</div><ul id="navigator"><li><a href="#up" class="uarr">&uarr;</a></li><li><a href="#next" class="rarr">&rarr;</a></li><li><a href="#down" class="darr">&darr;</a></li><li><a href="#prev" class="larr">&larr;</a></li></ul></div>');
    $('#navigatorContainer .baloon').delay(1500).fadeIn().delay(20000).fadeOut();
    
    
});

function goTo(id) {
    var anchor = $('div[id='+id+']');
    anchor.parents('.page').animate({scrollTop:anchor.position().top-10}, {duration:'slow',queue:false, complete:function() {
        $('#navigator a').removeClass('active');
    }});
}
function goDown() {
    var k = currentPage.find('.innerContainer > .active').next('div').attr('id');
    if (k != undefined)
        goTo(k);
}
function goUp() {
    var k = currentPage.find('.innerContainer > .active').prev('div').attr('id');
    if (k != undefined)
        goTo(k);
}
function goTop() {
    // var k = currentPage.find('.innerContainer > div').first('div').attr('id');
    // if (k != undefined)
    //     goTo(k);
    currentPage.animate({scrollTop:0}, {duration:'slow',queue:false, complete:function() {
        $('#navigator a').removeClass('active');
    }});
}
function goEnd() {
    var k = currentPage.find('.innerContainer > div').last('div').attr('id');
    if (k != undefined)
        goTo(k);
}

function resizeViewport() {
    globalContainer.css('height', wind.height()/*-menuHeight*/);
    allPages.css('width', wind.width());
    allPages.css('height', globalContainer.height());
    scrollableAPI.seekTo(scrollableAPI.getIndex(), 0);
    allPages.each(function() {
        if ($(this).find('div[title]').length != 0) {
            h1 = $(this).children('.innerContainer').height();
            if (h1 > 0) {
                h2 = $(this).find('div[title]:last').position().top;
                h3 = $(this).height();
                p = h3 - (h1 - h2) - 20;
                $(this).children('.innerContainer').css('padding-bottom', p+'px');
            }
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
