$(function () {
    $('form[data-ajaxform]').each(function (i, el) {
        var form = app.ajaxform.register($(el).data('ajaxform'), $(el));
    });
});

app.ajaxform = (function () {

    var forms = {};
    var callbacks = {};

    function register(name, form)
    {
        var formName = null;
        var $form    = null;

        if (typeof name == 'string') {
            formName = name;
            $form    = typeof form == 'object' ? form : getFormInstance(formName);
        } else if (typeof name == 'object') {
            formName = name.data('ajaxform');
            $form    = name;
        }

        if (!formName || !$form) {
            return;
        }

        return forms[formName] = new ajaxForm($form);
    }

    function callback(formName, cbs)
    {
        if (typeof cbs != 'object') {
            return;
        }

        if (typeof callbacks[formName] == "undefined") {
            callbacks[formName] = {};
        }

        callbacks[formName].done = cbs['done'] ? cbs['done'] : null;
        callbacks[formName].fail = cbs['fail'] ? cbs['fail'] : null;
        callbacks[formName].always = cbs['always'] ? cbs['always'] : null;
        callbacks[formName].before = cbs['before'] ? cbs['before'] : null;
    }

    function form(name)
    {
        return forms[name] ? forms[name] : null;
    }

    function getFormInstance(name)
    {
        return $("form[data-ajaxform='" + name + "']");
    }

    function ajaxForm($form)
    {
        $form.on('submit', function (e) {
            e.preventDefault();
            submit();
        });

        function submit()
        {
            var dataType = $form.data('ajaxform-type');
            var formName = $form.data('ajaxform');

            execCallback(formName, 'before');

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: dataType ? dataType : 'json',
                data: $form.serialize(),
            }).done(function (r) {
                execCallback(formName, 'done', r || null);
            }).fail(function (xhr, code, msg) {
                execCallback(formName, 'fail', code || null);
            }).always(function (r) {
                execCallback(formName, 'allways', r || null);
            });
        }

        return {
            submit: submit
        }
    }

    function execCallback(formName, callback, passthrou)
    {
        if (callbacks[formName] && typeof callbacks[formName][callback] == 'function') {
            var pass = passthrou ? passthrou : null;
            callbacks[formName][callback].call(this, pass);
        }
    }

    return {
        register: register,
        form: form,
        callback: callback
    }

})();
