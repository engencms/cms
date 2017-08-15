<?php $this->layout('admin::layout') ?>

    <form method="post" action="<?= $this->route('engen.blocks.save') ?>" id="form-edit-block" data-ajaxform="block-edit" data-ajaxform-button="edit-block-submit" target="_blank">

        <input type="hidden" name="id" id="frm-id" value="<?= $block->id ?>" />
        <input type="hidden" name="token" value="<?= $this->csrfToken('edit-block') ?>" />

        <div class="content-inner size-medium">

            <div class="form-item">
                <label for="frm-name">Name</label>
                <input type="text" id="frm-name" class="frm-block-name" name="name" value="<?= $this->e($block->name) ?>" />
            </div>

            <div class="form-columns col-1-2">

                <div class="form-item">
                    <label for="frm-key">Key</label>
                    <input type="text" id="frm-key" class="frm-block-key" name="key" value="<?= $this->e($block->key) ?>" />
                </div>

                <div class="form-item">
                    <label for="frm-definition">Block templates</label>
                    <select id="frm-definition" name="definition">>
                        <option value="">Select a definition file</option>
                        <?php foreach ($this->blockDefinitions() as $definition): ?>

                        <option value="<?= $definition ?>" <?= $block->definition == $definition ? 'selected' : '' ?>>
                            <?= $definition ?>
                        </option>

                        <?php endforeach ?>
                    </select>
                </div>

            </div>

            <?php
            $this->insert('admin::fields/show-fields', [
                'content' => $block->content,
                'fields'  => $this->blockDefinition($block->definition),
            ])
            ?>


        </div>

        <div id="form-actions">
            <button type="submit" class="confirm" id="edit-block-submit">
                <span>Save</span>
            </button>

            <button type="button" class="right" id="edit-block-preview" data-form-id="form-edit-block" data-url="<?= $this->route('engen.blocks.preview') ?>">
                <span>Preview</span>
            </button>
        </div>

    </form>
