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

        var url   = $(this).attr('href');

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

    makeSortable();
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

function makeSortable()
{
    var $sorts = $(".sortable");

    if ($sorts.length > 0) {
        $.each($sorts, function (i, el) {
            var sortable = new Sortable(el, {
                sort: true,  // sorting inside list
                delay: 0, // time in milliseconds to define when the sorting should start
                disabled: false, // Disables the sortable if set to true.
                store: null,  // @see Store
                animation: 250,  // ms, animation speed moving items when sorting, `0` — without animation
                handle: ".sortable-handle",  // Drag handle selector within list items
                draggable: ".sortable-item",  // Specifies which items inside the element should be draggable
                scroll: true, // or HTMLElement

                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
            });
        });
    }
}