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

    app.fields.registerFields();
});

app.fields = {
    registerFields: function () {
        this.registerMarkdownEditors();
    },

    registerMarkdownEditors: function () {
        var $mdes = $('.mde');
        $.each($mdes, function (index, el) {
            if (!$(this).hasClass('initialized')) {
                $(el).addClass('initialized');
                var simplemde = new SimpleMDE({
                    element: el,
                    spellChecker: false,
                    status: false,
                    tabSize: 4,
                    forceSync: true,
                    toolbar: [
                        'bold', 'italic', 'heading', '|', 'quote','unordered-list', 'ordered-list', '|',
                        {
                            name: "custom-link",
                            action: function customFunction (editor) {
                                 app.smdeExtend.links(editor);
                            },
                            className: "fa fa-link",
                            title: "Link"
                        },
                        {
                            name: "custom-image",
                            action: function customFunction (editor) {
                                 app.smdeExtend.files(editor);
                            },
                            className: "fa fa-image",
                            title: "Image"
                        },
                        '|', 'preview', 'side-by-side', 'fullscreen'
                    ]
                });
            }
        });
    }
};

app.smdeExtend = {

    links: function(editor) {
        var self     = this;
        var cm       = editor.codemirror;
        var pos      = pos || cm.getCursor("start");
        var stat     = cm.getTokenAt(pos);
        var selected = cm.getSelection();
        var insert   = selected ? ['[','](#url#)'] : ['[#label#](#url#)'];

        app.lbox.pageLinkSelector(function(label, url, target) {
            var params = {label: label, url: url};
            self._replaceSelection(cm, stat.link, insert, 'link', params);
        }, {label: selected});
    },

    files: function(editor) {
        var self    = this;
        var cm      = editor.codemirror;
        var pos     = pos || cm.getCursor("start");
        var stat    = cm.getTokenAt(pos);
        var selected = cm.getSelection();
        var insert   = selected ? ['![','](#url#)'] : ['![#alt#](#url#)'];

        app.lbox.fileSelector(function(url, alt) {
            if (!alt) {
                var alt = '';
            }
            var params = {url: url, alt: alt};
            self._replaceSelection(cm, stat.image, insert, 'image', params);
        });
    },

    _replaceSelection: function(cm, active, startEnd, type, params)
    {
        if(/editor-preview-active/.test(cm.getWrapperElement().lastChild.className))
            return;

        var text;
        var start      = startEnd[0];
        var end        = startEnd[1];
        var startPoint = cm.getCursor("start");
        var endPoint   = cm.getCursor("end");

        if (!type) {
            return;
        }

        if ('link' == type) {
            start  = start.replace("#label#", params.label || '');
            start  = start.replace("#url#", params.url || '');
            if (end) {
                end    = end.replace("#label#", params.label || '');
                end    = end.replace("#url#", params.url || '');
            } else {
                end = '';
            }
        }

        if ('image' == type) {
            start  = start.replace("#alt#", params.alt || '');
            start  = start.replace("#url#", params.url || '');
            if (end) {
                end    = end.replace("#alt#", params.alt || '');
                end    = end.replace("#url#", params.url || '');
            } else {
                end = '';
            }
        }

        if (active) {
            text = cm.getLine(startPoint.line);
            start = text.slice(0, startPoint.ch);
            end = text.slice(startPoint.ch);
            cm.replaceRange(start + end, {
                line: startPoint.line,
                ch: 0
            });
        } else {
            text = cm.getSelection();
            cm.replaceSelection(start + text + end);

            startPoint.ch += start.length;

            if (startPoint !== endPoint) {
                endPoint.ch += start.length;
            }
        }

        cm.setSelection(startPoint, endPoint);
        cm.focus();
    }
}
