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

    function pageLinkSelector(onSubmit)
    {
        openAjax('/pages/page-link-selector', function () {
            $('#page-link-selector-form').on('submit', function (e) {
                e.preventDefault();
                onSubmit.call(
                    this,
                    $('#page-link-selector-label'),
                    $('#page-link-selector-url'),
                    $('#page-link-selector-target'),
                )
            });
        });
    }

    function open(content)
    {
        $content.html(content);
        $box.addClass('show');
    }

    function close()
    {
        $box.removeClass('show');
    }

    return {
        init: init,
        open: open,
        close: close,
        pageLinkSelector: pageLinkSelector
    }
})();