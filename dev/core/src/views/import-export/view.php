<?php $this->layout('admin::layout') ?>

<div class="content-inner">

    <div id="import">

        <h1>Import</h1>

        <form method="post" action="<?= $this->route('engen.import-export.import') ?>?<?= time() ?>" id="form-import" data-ajaxform="import" data-ajaxform-button="edit-import-submit" target="_blank">

            <button type="button" class="" id="upload-import-file-submit">
                <span>Select file to import</span>
            </button>

        </form>

    </div>


    <div id="export">

        <h1>Export</h1>

    </div>

</div>
