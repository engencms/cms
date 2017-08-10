<?php $this->layout('admin::layout') ?>

    <form method="post" action="<?= $this->route('engen.settings.save') ?>" id="form-edit-settings" data-ajaxform="settings-edit" data-ajaxform-button="edit-settings-submit">

        <input type="hidden" name="token" value="<?= $this->csrfToken('edit-settings') ?>" />

        <div class="tabs">

            <div class="tab-links">
                <a href="#" data-tab="tab-site-settings" class="open">Site settings</a>
            </div>

            <div class="content-inner">

                <div id="tab-site-settings" class="tab size-medium open">

                    <?php
                    $this->insert('admin::fields/string', [
                        'label'    => 'Site name',
                        'key'      => 'site_name',
                        'value'    => $this->setting('site_name'),
                        'settings' => [],
                        'name'     => 'site[site_name]',
                        'id'       => 'frm-site-site_name'
                    ]);
                    ?>

                </div>

            </div>

        </div>

        <div id="form-actions">
            <button type="submit" class="confirm" id="edit-settings-submit">
                <span>Save</span>
            </button>
        </div>

    </form>
