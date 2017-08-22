$(function () {
    app.lbox.init();
});

app.lbox = (function () {
    var $box;
    var $content;
    var state = 0;

    function init()
    {
        $box     = $('#lightbox');
        $content = $('#lightbox-content');
        $close   = $('#lightbox-close');

        $('body').on('click', '#lightbox-close', function (e) {
            e.preventDefault();
            close();
        });

        $('body').on('click', '#lightbox-inner', function (e) {
            if (e.target !== this) {
                return;
            }

            close();
        });
    }

    function pageLinkSelector(onConfirm, params)
    {
        if (!params) {
            var params = {};
        }

        openAjax('/admin/partials/page-link-selector', function () {
            $('#lightbox-confirm').on('click', function (e) {
                e.preventDefault();
                var label  = $('#page-link-selector-label').val();
                var url    = $('#page-link-selector-page-key').val();
                var target = $('#page-link-selector-target').val();

                url = url ? '[page-key:' + url + ']' : $('#page-link-selector-url').val();

                onConfirm.call(this, label, url, target);
                close();
            });
        }, params);
    }

    function fileSelector(onConfirm, params)
    {
        if (!params) {
            var params = {};
        }

        openAjax('/admin/partials/file-selector', function () {
            $('a.file-selector-url').on('click', function (e) {
                e.preventDefault();
                onConfirm.call(this, $(this).attr('href'));
                close();
            });
        }, params);
    }

    function open(content)
    {
        $content.html(content);
        $box.addClass('show');
        $('body').addClass('no-scroll');
    }

    function openAjax(url, onSuccess, data)
    {
        if (!data) {
            var data = {};
        }

        $.get(url, data, function (content) {
            open(content);
            onSuccess.call(this);
        });
    }

    function close()
    {
        $box.removeClass('show');
        $('body').removeClass('no-scroll');
    }

    return {
        init: init,
        open: open,
        close: close,
        pageLinkSelector: pageLinkSelector,
        fileSelector: fileSelector
    }
})();