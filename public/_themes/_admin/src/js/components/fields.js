$(function () {
    $('#add-field-btn').on('click', function (e) {
        e.preventDefault();

        var $this = $(this);
        var tmpl  = $('#' + $this.data('template')).html();

        $this.before(tmpl);
    });
});
