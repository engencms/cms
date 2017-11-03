$(function () {
    app.ajaxform.callback('import', {
        before: function ($btn) {
            app.formStatus.disableButton($btn);

        },

        done: function (r, $btn) {
            if (r.success()) {
                app.notify.success(r.message());
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