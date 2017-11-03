$(function () {
    app.ajaxform.callback('block-edit', {
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

    $('.frm-block-name').on('blur', function () {
        var name   = $(this).val();
        var key    = $('#frm-key').val();
        var id     = $('#frm-id').val();

        if (key == '') {
            createBlockKey(name, id, $("#frm-key"));
        }
    });

    $('.frm-block-key').on('blur', function () {
        var name   = $('#frm-name').val();
        var key    = $(this).val();
        var id     = $('#frm-id').val();

        if (key == '') {
            if (title) {
                createBlockKey(title, id, $(this));
            }
        } else {
            createBlockKey(key, id, $(this));
        }
    });
});

function createBlockKey(text, id, $key)
{
    $.get('/admin/blocks/slugify-key', { text: text, block_id: id}, function (res) {
        var r = app.response.make(res || false);
        if (r.success()) {
            $key.val(r.data());
        }
    });
}