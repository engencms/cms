$(function () {
    $('#add-field-btn').on('click', function (e) {
        e.preventDefault();

        var $this  = $(this);
        var tmpl  = $('#' + $this.data('template')).html();

        $(tmpl).insertBefore($this.parent());
    });

    $('.group-expand').on('click', function (e) {
        e.preventDefault();

        var $this  = $(this);
        var $group = $this.closest('.form-group');

        if ($group.hasClass('open')) {
            $group.removeClass('open');
        } else {
            $group.addClass('open');
        }
    });

    $('body').on('click', '.group-item-remove', function (e) {
        e.preventDefault();

        var $group = $(this).closest('.group-content');

        $group.addClass('remove');

        $group.slideUp(400, function () {
            $(this).remove();
        });
    });
});
