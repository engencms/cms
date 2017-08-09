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
            var buttonId = $form.data('ajaxform-button');
            var $button  = $("#" + buttonId).length > 0 ? $("#" + buttonId) : null;

            execCallback(formName, 'before', undefined, $button);

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: dataType ? dataType : 'json',
                data: $form.serialize(),
            }).done(function (r) {
                execCallback(formName, 'done', new response(r || null), $button);
            }).fail(function (xhr, code, msg) {
                execCallback(formName, 'fail', code || null, $button);
            }).always(function (r) {
                execCallback(formName, 'always', new response(r || null), $button);
            });
        }

        return {
            submit: submit
        }
    }

    function response(r)
    {
        function success()
        {
            return r && r.success;
        }

        function hasErrors()
        {
            return r && r.errors && (r.errors.length > 0 || !$.isEmptyObject(r.errors));
        }

        function errors()
        {
            return hasErrors() ? r.errors : [];
        }

        function data()
        {
            return typeof r.data != 'undefined' ? r.data : null;
        }

        function message()
        {
            return typeof r.message != 'undefined' ? r.message : null;
        }

        function code()
        {
            return typeof r.code != 'undefined' ? r.code : 0;
        }

        function raw()
        {
            return r ? r : null;
        }

        return {
            success: success,
            errors: errors,
            hasErrors: hasErrors,
            data: data,
            message: message,
            code: code,
            raw: raw
        }
    }

    function execCallback(formName, callback, passthrou, $button)
    {
        if (callbacks[formName] && typeof callbacks[formName][callback] == 'function') {

            if (passthrou == undefined) {
                callbacks[formName][callback].call(this, $button);
                return;
            }

            callbacks[formName][callback].call(this, passthrou, $button);
        }
    }

    return {
        register: register,
        form: form,
        callback: callback
    }

})();

