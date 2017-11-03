$(function () {
    app.ajaxform.callback('menu-edit', {
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

    $('#menu-items-list').on('change', '.link-type-select', function (e) {
        var val     = $(this).val();
        var $parent = $(this).closest('.item');

        $('.link-type-action', $parent).removeClass('selected');
        $('.link-type-' + val, $parent).addClass('selected');
    });

    $('#menu-items-list').on('click', '.remove-item-btn', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to completely remove this item?')) {
            $(this).closest('.item').remove();
        }
    });

    $('#add-menu-item-btn').on('click', function (e) {
        e.preventDefault();

        $($('#menu-item-template').html()).insertBefore('#menu-item-add-row');
    });
});