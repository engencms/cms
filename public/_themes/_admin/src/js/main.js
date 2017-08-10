if (!app) {
    var app = {};
}

$(function () {
    $('body').on('click', '#delete-sub-nav-btn', function (e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete this item?\nThis cannot be undone!')) {
            var data = {
                ref:   $(this).data('ref'),
                token: $(this).data('token')
            };

            $.post($(this).attr('href'), data, function (r) {
                var r = app.response.make(r);

                if (r.success()) {
                    location.href = r.data();
                    return;
                }

                var errors = r.hasErrors()
                    ? r.errors()
                    : ['Unknown error'];

                app.notify.error(errors);
            }, 'json').fail(function () {
                app.notify.error('An unknow server error occurred');
            });
        }
    });

    $('#build-btn').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.post(url, function (response) {
            var r = app.response.make(response || false);
            if (r.success()) {
                app.notify.success('Built!');
                return;
            }
            app.notify.error('An error occurred');
        }, 'json').fail(function () {
            app.notify.error('A request error occurred');
        });
    });
});

app.formStatus = {
    timer: null,

    disableButton: function ($btn)  {
        if (!$btn) {
            return;
        }

        $btn.addClass('loading');
        $btn.prop('disabled', true);
    },

    enableButton: function ($btn)  {
        if (!$btn) {
            return;
        }

        $btn.removeClass('loading');
        $btn.prop('disabled', false);
    }
};