$(function () {
    $('.tab-links a').on('click', function (e) {
        e.preventDefault();

        var $tabLink = $(this);

        if ($tabLink.hasClass('open')) {
            return;
        }

        var id         = $tabLink.data('tab');
        var $container = $tabLink.closest('.tabs')

        $('.tab', $container).removeClass('open');
        $tabLink.siblings().removeClass('open');

        $tabLink.addClass('open');
        $('#' + id).addClass('open');
    });
});
