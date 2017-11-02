<?php $this->layout('admin::layout') ?>

    <form method="post" action="<?= $this->route('engen.pages.save') ?>?<?= time() ?>" id="form-edit-page" data-ajaxform="page-edit" data-ajaxform-button="edit-page-submit" target="_blank">

        <input type="hidden" name="id" id="frm-id" value="<?= $page->id ?>" />
        <input type="hidden" name="token" value="<?= $this->csrfToken('edit-page') ?>" />

        <div class="tabs">

            <div class="tab-links">
                <a href="#" data-tab="tab-content" class="open">Page content</a>
                <a href="#" data-tab="tab-info">Page info</a>
            </div>

            <div class="content-inner">

                <div id="tab-info" class="tab size-medium">

                    <div class="form-columns col-1-2">

                        <div class="form-item">
                            <label for="frm-slug">Slug</label>
                            <input type="text" id="frm-slug" class="frm-page-slug" name="info[slug]" value="<?= $this->e($page->slug) ?>" />
                        </div>

                        <div class="form-item">
                            <label for="frm-key">Key</label>
                            <input type="text" id="frm-key" class="frm-page-key" name="info[key]" value="<?= $this->e($page->key) ?>" />
                        </div>

                    </div>

                    <div class="form-columns col-1-2">

                        <div class="form-item">
                            <label for="frm-template">Template</label>
                            <select id="frm-template" name="info[template]">>
                                <option value="">Select a template</option>
                                <?php foreach ($this->pageTemplates() as $template) : ?>

                                <option value="<?= $template ?>" <?= $page->template == $template ? 'selected' : '' ?>>
                                    <?= $template ?>
                                </option>

                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-item">
                            <label for="frm-parent_id">Parent</label>
                            <select id="frm-parent_id" name="info[parent_id]">
                                <option value="">No parent</option>

                                <?php $this->pageOptions($page->id, $page->parent_id, true, 'root') ?>

                            </select>
                        </div>

                    </div>

                    <div class="form-columns col-1-2">

                        <div class="form-item">
                            <label for="frm-status">Status</label>
                            <select id="frm-status" name="info[status]">>
                                <option value="published" <?= $page->status == 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="draft" <?= $page->status == 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>

                        <div class="form-item">
                            <label for="frm-is_home">Is home page</label>
                            <label class="normal">
                                <input type="checkbox" id="frm-is_home" name="info[is_home]" value="1" <?= $page->is_home || count($this->pages()) == 0? 'checked' : ''?> /> Set this page as the home page
                            </label>
                        </div>

                    </div>

                </div>

                <div id="tab-content" class="tab size-medium open">

                    <div class="form-item">
                        <label for="frm-title">Title</label>
                        <input type="text" id="frm-title" class="frm-page-title" name="info[title]" value="<?= $this->e($page->title) ?>" />
                    </div>

                    <?php
                    $this->insert('admin::fields/show-fields', [
                        'content' => $page->content,
                        'fields'  => $this->pageDefinition($page->template),
                    ])
                    ?>

                </div>

            </div>

        </div>

        <div id="form-actions">
            <button type="submit" class="confirm" id="edit-page-submit">
                <span>Save</span>
            </button>

            <button type="button" class="right" id="edit-page-preview" data-form-id="form-edit-page" data-url="<?= $this->route('engen.pages.preview') ?>">
                <span>Preview</span>
            </button>
        </div>

    </form>
