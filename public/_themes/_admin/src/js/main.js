if (!app) {
    var app = {};
}

$(function () {
    $('body').on('click', '#delete-sub-nav-btn', function (e) {
        e.preventDefault();

        app.delete.item($(this), function (r) {
            location.href = r.data();
        });
    });

    $('body').on('click', '.delete-file-btn', function (e) {
        e.preventDefault();

        app.delete.item($(this), function (r) {
            location.reload();
        });
    });

    $('#build-btn').on('click', function (e) {
        e.preventDefault();

        var $form = $("#build-form");

        if ($("#build-form").length == 0) {
            var url   = $(this).attr('href');

            $form = $('<form id="build-form" />')
                .attr('action', url)
                .attr('target', '_blank')
                .attr('method', 'post');

            $('body').append($form);
        }

        $form.submit();
        return;

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

app.delete = {

    item: function ($this, successCallback) {
        if (confirm('Are you sure you want to delete this item?\nThis cannot be undone!')) {
            var data = {
                ref:   $this.data('ref'),
                token: $this.data('token')
            };

            $.post($this.attr('href'), data, function (r) {
                var r = app.response.make(r);

                if (r.success()) {
                    successCallback.call(this, r);
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
    },

    items: function ($this, refs, successCallback) {
        if (confirm('Are you sure you want to delete these items?\nThis cannot be undone!')) {
            var data = {
                ref: refs,
                token: $this.data('token')
            };

            $.post($this.attr('href'), data, function (r) {
                var r = app.response.make(r);

                if (r.success()) {
                    successCallback.call(this, r);
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
    }
};

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