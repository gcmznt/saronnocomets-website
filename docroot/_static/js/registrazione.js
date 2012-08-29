(function($){
    $(document).ready(function(){
        $('#inputTorneo').change(function(){
            if ($('#inputTorneo').val() == 'classic') {
                $('#codeGroup').hide();
            } else {
                $('#codeGroup').show();
            }
        });
        $('#inputTorneo').change();

        $('input').focus(function(){
            $(this).parents('.control-group').removeClass('error');
        });

        $('#inputTorneo').change(function(){
            calcolaPrezzo();
        });
        $('#inputSaturnday, #inputSunday').keyup(function(){
            calcolaPrezzo();
        });

        calcolaPrezzo();

        $('#tds-form').submit(function(){
            var form = $(this);
            form.find('button[type=submit]').after('<img src="/_static/img/ajax-loader.gif" class="loader" />');
            form.find('.alert').hide(30, function(){ $(this).empty(); });

            $.ajax({
                type: 'POST',
                url: '/torneo-di-saronno/submit/',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'ko') {
                        form.find('.loader').remove();

                        var errorBox = form.find('.alert').removeClass('alert-success').addClass('alert-error');
                        if (errorBox.length == 0) {
                            errorBox = $('<div class="alert alert-error"></div>');
                            errorBox.hide();
                            form.append(errorBox);
                        }

                        if (data.message != undefined) {
                            errorBox.append(data.message + '<br />');
                        }
                        
                        $.each(data.errors, function(key, value) { 
                            form.find('#' + key).parents('.control-group').addClass('error');
                            errorBox.append(value + '<br />');
                        });
                        errorBox.show(100);
                    } else if (data.status == 'ok') {
                        form.find('.loader').remove();
                        form.find('input').val('');

                        var errorBox = form.find('.alert').removeClass('alert-error').addClass('alert-success');
                        if (errorBox.length == 0) {
                            errorBox = $('<div class="alert alert-success"></div>');
                            errorBox.hide();
                            form.append(errorBox);
                        }

                        if (data.message != undefined) {
                            errorBox.append(data.message + '<br />');
                            errorBox.show(100);
                        }
                    }
                },
                error: function(){
                    form.find('.loader').remove();
                    var errorBox = form.find('.alert').removeClass('alert-success').addClass('alert-error');
                    if (errorBox.length == 0) {
                        errorBox = $('<div class="alert alert-error"></div>');
                        errorBox.hide();
                        form.append(errorBox);
                    }

                    errorBox.append('Errore durante il salvataggio, riprovare più tardi<br />');
                    errorBox.show(100);
                }
            });

            return false;
        });
    });
})(jQuery);

function calcolaPrezzo() {
    var t = ($('#inputTorneo').val() == 'classic') ? 40 : 0;
    var sat = parseInt($('#inputSaturnday').val(), 10);
    var sun = parseInt($('#inputSunday').val(), 10);
    sat = (isNaN(sat)) ? 0 : sat;
    sun = (isNaN(sun)) ? 0 : sun;
    var p = (sat + sun) * 5;
    var tot = t + p;
    $('#totale').html(tot);
}