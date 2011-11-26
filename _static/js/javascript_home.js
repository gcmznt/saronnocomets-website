$(document).ready(function() {
	$('.partite .data span').each(function() {
        var val1 = $(this).html();
        var val = $(this).html();
        val = moment(val, 'D/MM/YYYY h:mm:ss').format('DD-MM-YYYY');
        $(this).html(val);
    });

});