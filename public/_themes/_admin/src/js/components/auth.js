$(function () {
    $('.login-view-btn').on('click', function (e) {
        e.preventDefault();

        var $view = $('#' + $(this).data('show'));

        $('.login-view').hide();
        $view.show();
        $('.focus', $view).focus();
    });

    app.ajaxform.callback('login', {
        before: function ($btn) {
            app.formStatus.disableButton($btn);
        },

        done: function (r, $btn) {
            if (r.success()) {
                location.href = r.data();
                return;
            }

            var errors = r.hasErrors()
                ? r.errors()
                : ['Unknown error'];

            app.notify.error(errors);
        },

        fail: function () {
            app.notify.error('An unknown server error occrurred');
        },

        always: function (response, $btn) {
            app.formStatus.enableButton($btn);
        }
    });

    app.ajaxform.callback('login-forgot', {
        before: function ($btn) {
            app.formStatus.disableButton($btn);
        },

        done: function (r, $btn) {
            if (r.success()) {
                $('#login-forgot-message').addClass('success')
                    .html('We have sent an e-mail to the e-mail address, if it has an account registered.');
                return;
            }

            var errors = r.hasErrors()
                ? r.errors()
                : ['Unknown error'];

            app.notify.error(errors);
        },

        fail: function () {
            app.notify.error('An unknown server error occrurred');
        },

        always: function (response, $btn) {
            app.formStatus.enableButton($btn);
        }
    });
});