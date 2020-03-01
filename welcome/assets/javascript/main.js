(function($, Wow) {
  "use strict";

    $(document).ready(function () {

        // Change the 'date' variable value to your desierd future date
        $('#countdown').downCount({
            date: '12/24/2016 12:00:00', // CHANGE THE DATE
            offset: -4 // CHANGE UTC OFFSET
        });

        /*$('.twitter .tweet').twittie({
            username: 'themewizz',
            dateFormat: '%b. %d, %Y',
            template: '<strong class="date">{{date}}</strong> - {{tweet}}',
            count: 10
        }, function () {
            setInterval(function() {
                var item = $('.twitter .tweet ul').find('li:first');

                item.animate( {marginLeft: '-320px', 'opacity': '0'}, 500, function() {
                    $(this).detach().appendTo('.twitter .tweet ul').removeAttr('style');
                });
            }, 5000);
        });*/

        // This is a subscribe form action
        $('#subscribe button').on('click', function (e) {
            var error = 0;
            e.preventDefault();

            $('#subscribe input').each(function () {
                if($(this).val().length > 0) {
                    $(this).parents('div').removeClass('error');
                } else {
                    $(this).parents('div').addClass('error');
                    error = 1;
                }
            });

            if(error == 1) {
                $('.success_alert').fadeOut(function() {
                    $('.error_alert').fadeIn();
                });
            } else {
                $.post('api/mailchimp.php', { email: $('#subscribe input[name="email"]').val() }, function(response) {
                    if ( response.error ){
                        $('.error_alert').html(response.message);

                        $('.success_alert').fadeOut(function () {
                            $('.error_alert').fadeIn();
                        });
                    } else {
                        $('.success_alert').html(response.message);

                        $('.error_alert').fadeOut(function () {
                            $('.success_alert').fadeIn();
                        });
                    }
                });
            }
        });

        $('*[data-smoothscroll="true"]').smoothScroll();

        new Wow().init();

        window.ParsleyConfig = {
            errorClass: 'has-error',
            successClass: 'has-success',
            classHandler: function(ParsleyField) {
                return ParsleyField.$element.parents('.form-group');
            },
            errorsContainer: function(ParsleyField) {
                return ParsleyField.$element.parents('.form-group');
            },
            errorsWrapper: '<span class="help-block">',
            errorTemplate: '<div></div>'
        };

        $('#contactus').parsley();

        /**
          * Contact Form
          */
        $('#contactus').submit(function (e) {
            e.preventDefault();

            var $name    = $(this).find('input[name="name"]'),
                $email   = $(this).find('input[name="email"]'),
                $message = $(this).find('textarea[name="message"]');

            $.post('api/email.php', {
                name:    $name.val(),
                email:   $email.val(),
                message: $message.val()
            }, function (response) {
                $name.val('');
                $email.val('');
                $message.val('');

                $('#success').show();
            });
        });
    });

})(jQuery, WOW);