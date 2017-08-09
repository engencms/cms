if (!app) {
    var app = {};
}

$(function () {
    /**
    var el = document.querySelector('.recursive-list');
    var sortable = new Sortable(el, {
        sort: true,  // sorting inside list
        delay: 0, // time in milliseconds to define when the sorting should start
        disabled: false, // Disables the sortable if set to true.
        store: null,  // @see Store
        animation: 150,  // ms, animation speed moving items when sorting, `0` — without animation
        handle: ".handle",  // Drag handle selector within list items
        draggable: ".row",  // Specifies which items inside the element should be draggable
        scroll: true, // or HTMLElement
    });
    */
});

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