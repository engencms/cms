$(function () {
    app.ajaxform.callback('page-edit', {
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

    $('.frm-page-title').on('blur', function () {
        var title  = $(this).val();
        var slug   = $('#frm-slug').val();
        var key    = $('#frm-key').val();
        var id     = $('#frm-id').val();
        var parent = $('#frm-parent_id').val();

        if (slug == '') {
            createPageSlug(title, id, parent, $("#frm-slug"));
        }

        if (key == '') {
            createPageKey(title, id, $("#frm-key"));
        }
    });

    $('.frm-page-slug').on('blur', function () {
        var title  = $('#frm-title').val();
        var slug   = $(this).val();
        var id     = $('#frm-id').val();
        var parent = $('#frm-parent_id').val();

        var text = slug;

        if (slug == '' && title == '') {
            return;
        }

        if (slug == '' && title != '') {
            text = title;
        }

        createPageSlug(text, id, parent, $(this));
    });

    $('.frm-page-key').on('blur', function () {
        var title  = $('#frm-title').val();
        var key    = $(this).val();
        var id     = $('#frm-id').val();

        if (key == '') {
            createPageKey(title, id, $(this));
        }
    });

    $('#edit-page-preview').on('click', function (e) {
        e.preventDefault();
        var $this   = $(this);
        var newUrl  = $this.data('url');
        var $form   = $('#' + $this.data('form-id'));
        var realUrl = $form.attr('action');

        $form.attr('action', newUrl);
        $form.data('disable-ajax', 1);

        $form.submit();

        $form.attr('action', realUrl);
        $form.data('disable-ajax', 0);
    });

});

function createPageSlug(text, pageId, parentId, $slug)
{
    $.get('/admin/pages/slugify-slug', { text: text, page_id: pageId, parent_id: parentId}, function (res) {
        var r = app.response.make(res || false);
        if (r.success()) {
            $slug.val(r.data());
        }
    });
}

function createPageKey(text, pageId, $key)
{
    $.get('/admin/pages/slugify-key', { text: text, page_id: pageId}, function (res) {
        var r = app.response.make(res || false);
        if (r.success()) {
            $key.val(r.data());
        }
    });
}