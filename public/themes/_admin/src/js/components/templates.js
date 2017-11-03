if (!app) {
    var app = {};
}

app.template = (function () {
    /**
     * @type Boolean
     */
    var initialized = false;

    /**
     * Added template filters
     * @type Object
     */
    var filters   = {};

    /**
     * Generated template definitions
     * @type Object
     */
    var templates = {};

    /**
     * Render a template
     *
     * @param  string template
     * @param  object data
     * @return string
     */
    function render(template, data)
    {
        if (!initialized) {
            addDefaultFilters();
            initialized = true;
        }

        if (!templates[template]) {
            if (!document.getElementById(template)) {
                return;
            }

            var tpl = document.getElementById(template).innerHTML;
            templates[template] = {
                tpl: tpl,
                phs: getPlaceholders(tpl),
            }
        }

        return buildTemplate(template, data);
    }

    /**
     * Replace placeholders and build the template
     *
     * @param  string template
     * @param  object data
     * @return string
     */
    function buildTemplate(template, data)
    {
        var tpl = templates[template];
        var markup = tpl.tpl;

        if (tpl.phs.length == 0 || typeof data !== 'object') {
            return markup;
        }

        for (var i in tpl.phs) {
            var ph = tpl.phs[i];
            var value = runBeforeFilters(
                (data[ph.key] ? data[ph.key] : null),
                ph.before
            );

            markup = markup.replace(ph.placeholder, value);
        }

        return markup;
    }

    function runBeforeFilters(value, before)
    {
        if (before.length == 0) {
            return value === null ? '' : value;
        }

        for (var i in before) {
            if (value === null) {
                if (before[i].fn === 'default') {
                    // We have no value but a default filter, return the
                    // default value instead
                    return before[i].params[0] ? before[i].params[0] : '';
                }

                continue;
            }

            if (!filters[before[i].fn]) {
                continue;
            }

            var params = before[i].params.slice();

            params.unshift(value);
            value = filters[before[i].fn].apply(this, params);
        }

        return value;
    }

    /**
     * @param  string tpl
     * @return array
     */
    function getPlaceholders(tpl)
    {
        var phs = tpl.match(/{{([^{}]+)}}/g);
        return parsePlaceHolders(phs);
    }

    /**
     * @param  array phs
     * @return array
     */
    function parsePlaceHolders(phs)
    {
        var items = [];
        for (var i in phs) {
            var data = phs[i].replace('{{', '').replace('}}', '').split('|');

            items.push({
                placeholder: phs[i],
                key: data.shift(),
                before: parseBeforeFilters(data),
            });
        }

        return items;
    }

    /**
     * @param  array data
     * @return array
     */
    function parseBeforeFilters(data)
    {
        var before = [];
        for (var i in data) {
            var parts = data[i].split(',');
            before.push({
                fn: parts.shift(),
                params: parts
            });
        }

        return before;
    }

    /**
     * Add a new template filter
     *
     * @param  string   name
     * @param  Function callback
     * @return this
     */
    function filter(name, callback)
    {
        filters[name] = callback;
        return this;
    }

    /**
     * Add some helper filters
     */
    function addDefaultFilters()
    {
        // Date Time
        filter('ts2date', function (value, locale) {
            if (!locale) {
                var locale = undefined;
            }

            var date = new Date(value*1000);
            return date.toLocaleString(locale);
        });

        // selected
        filter('selected', function (value, compare) {
            return value == compare ? 'selected' : '';
        });

        // checked
        filter('checked', function (value, compare) {
            return value == compare ? 'checked' : '';
        });

        // equal
        filter('eq', function (value, compare, onTrue, onFalse) {
            if (value == compare) {
                return typeof onTrue !== 'undefined' ? onTrue : true;
            }

            return typeof onFalse !== 'undefined' ? onFalse : true;
        });
    }

    /**
     * Exposed methods
     */
    return {
        render: render,
        filter: filter
    }

})();
