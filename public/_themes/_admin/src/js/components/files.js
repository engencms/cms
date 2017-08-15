$(function () {
    $('#add-files-btn').on('click', function (e) {
        e.preventDefault();

        var url      = $(this).data('url');
        var token    = $(this).data('token');

        app.upload.fileSelect(url, token);
    });

    $('#toggle-file-list-select').on('click', function () {
        var toggle   = $(this).prop('checked');
        var $checked = $('input[name="selected[]"]:checked');

        if (!toggle) {
            $checked.prop('checked', false);
            return;
        }

        $('input[name="selected[]"]').prop('checked', true);

    });

    $('#files-delete-selected').on('click', function (e) {
        e.preventDefault();
        var $checked = $('input[name="selected[]"]:checked');
        var files    = [];

        if ($checked.length == 0) {
            return;
        }

        files = $checked.map(function(){
            return $(this).val();
        }).get();

        app.delete.items($(this), files, function (r) {
            location.reload();
        });
    });
});

app.upload = (function () {

    function fileSelect(url, token)
    {
        var $input   = $('<input type="file" name="files" multiple />');

        $input.on('change', function () {
            if ($input[0].files.length > 0) {
                upload($input[0].files, url, token);
            }
        }).trigger('click');
    }

    function upload(files, url, token)
    {
        var formData = new FormData;

        $.each(files, function (i, val) {
            formData.append('uploads[]', val);
        });

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                /*
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = Math.floor((e.loaded / e.total) * 100);
                            $("#progress-value").html(percent + '%');
                            $("#progress-bar").css('width', percent + '%');
                        }
                    }, false);
                }
                return myXhr;
                */
                return myXhr;
            },
            cache:false,
            success: function(res) {
                var r = app.response.make(res || false);
                if (r.success()) {
                    location.reload();
                    return;
                }

                var errors = r.hasErrors()
                    ? r.errors()
                    : ['Unknown error'];

                app.notify.error(errors);
            },
            error: function(data, textStatus, jqXHR) {
               app.notify.error('A request error occurred');
            }
        });
    }

    return {
        fileSelect: fileSelect
    }
})();