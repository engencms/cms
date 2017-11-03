app.notify = (function () {
    var $container;
    var timeout = 8000;
    var fade = 300;

    function info(msg)
    {
        message(msg, 'info');
    }

    function error(msg)
    {
        message(msg, 'error');
    }

    function success(msg)
    {
        message(msg, 'success');
    }

    function message(msg, type)
    {
        var message = stringify(msg);

        if (!message) {
            return;
        }

        $msg = $('<div class="message" />')
            .addClass(type)
            .html(message);

        container().append($msg);

        $msg.fadeIn(fade, function () {
            var $this = $(this);
            var timer = setTimeout(function () {
                close($this);
            }, timeout);

            $this.on('click', function (e) {
                close($this);
            })
        });
    }

    function close($msg, timer)
    {
        $msg.fadeOut(fade, function () {
            $(this).remove();
        });
    }

    function container()
    {
        if (!$container) {
            $container = $("#notify");
        }

        return $container;
    }

    function stringify(msg)
    {
        if (typeof msg == 'string') {
            return msg;
        }

        if (typeof msg == 'object') {
            var rows = [];
            $.each(msg, function (i, value) {
                rows.push(value);
            });

            return rows.join('<br />');
        }

        return false;
    }

    return {
        info: info,
        error: error,
        success: success
    }
})();