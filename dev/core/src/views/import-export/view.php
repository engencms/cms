<?php $this->layout('admin::layout') ?>

    <div class="content-inner">

        <h1>Import</h1>

        <form method="post" action="<?= $this->route('engen.import-export.import') ?>?<?= time() ?>" id="form-import" data-ajaxform="import" data-ajaxform-button="edit-import-submit" target="_blank">

            <div id="form-actions" class="inline">
                <button type="button" class="" id="upload-import-file-submit">
                    <span>Select file</span>
                </button>

                <button type="submit" class="confirm" id="edit-import-submit">
                    <span>Import</span>
                </button>
            </div>

        </form>

        <h1>Export</h1>


    </div>
