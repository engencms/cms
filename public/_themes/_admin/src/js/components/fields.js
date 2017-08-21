$(function () {
    $('.group-title .add-field-btn').on('click', function (e) {
        e.preventDefault();

        var $this   = $(this);
        var $group  = $('#' + $this.data('group-id'));
        var tmpl    = $('#' + $this.data('template')).html();

        $(tmpl).insertAfter($('.group-title', $group));
        registerFields();
        $('.group-content.new', $group).slideDown(1700, function () {
            $(this).removeClass('new');
        });
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

        $group.slideUp(600, function () {
            $(this).remove();
        });
    });

    registerFields();
});

function registerFields()
{
    registerMarkdownEditors();
}

function registerMarkdownEditors()
{
    var $mdes = $('.mde');
    $.each($mdes, function (index, el) {
        if (!$(this).hasClass('initialized')) {
            $(el).addClass('initialized');
            var simplemde = new SimpleMDE({
                element: el,
                promptURLs: true,
                spellChecker: false,
                status: false,
                tabSize: 4,
            });
        }
    });
}
