<?php $this->layout('admin::layout') ?>

    <form method="post" action="<?= $this->route('engen.menus.save') ?>" id="form-edit-menu" data-ajaxform="menu-edit" data-ajaxform-button="edit-menu-submit">

        <input type="hidden" name="id" id="frm-id" value="<?= $menu->id ?>" />
        <input type="hidden" name="token" value="<?= $this->csrfToken('edit-menu') ?>" />

        <div class="content-inner">

            <div class="form-columns col-1-2">

                <div class="form-item">
                    <label for="frm-name">Name</label>
                    <input type="text" id="frm-name" name="menu[name]" value="<?= $this->e($menu->name) ?>" />
                </div>

                <div class="form-item">
                    <label for="frm-key">Key</label>
                    <input type="text" id="frm-key" name="menu[key]" value="<?= $this->e($menu->key) ?>" />
                </div>

            </div>

            <h2 class="form-heading">Items</h2>

            <div class="table" id="menu-items-list">

                <div class="header">

                    <div class="prop menu-name">Menu label</div>
                    <div class="prop link-type">Link type</div>
                    <div class="prop link">Link</div>
                    <div class="prop target">Target</div>

                </div>

            <?php foreach ($menu->items as $item): ?>

                <div class="item">

                    <div class="prop menu-name">
                        <input type="text" value="<?= $item->label ?>" name="item[][label]" />
                    </div>
                    <div class="prop link-type">
                        <select class="link-type">
                            <option value="page" <?= $item->page_id ? 'selected' : '' ?>>Link to page</option>
                            <option value="custom" <?= !$item->page_id ? 'selected' : '' ?>>Custom</option>
                        </select>
                    </div>
                    <div class="prop link">
                        <div class="link-type-page hide <?= $item->page_id ? 'selected' : ''?>">
                            <select name="item[][page_id]">
                                <?php $this->pageOptions($item->page_id, $item->page_id) ?>
                            </select>
                        </div>
                        <div class="link-type-custom hide <?= !$item->page_id ? 'selected' : ''?>">
                            <input type="text" value="<?= !$item->page_id ? $item->link : '' ?>" name="item[][link]" />
                        </div>
                    </div>
                    <div class="prop target">
                        <select name="item[][target]">
                            <option value="" <?= $item->target != '_blank' ? 'selected' : '' ?>>Self</option>
                            <option value="_blank" <?= $item->target == '_blank' ? 'selected' : '' ?>>New window/tab</option>
                        </select>
                    </div>

                </div>

            <?php endforeach ?>

                <div class="item add">

                    <div class="prop"><a href="#">+ Add a menu item</a></div>
                    <div class="prop"></div>
                    <div class="prop"></div>
                    <div class="prop"></div>

                </div>


            </div>


        </div>

        <div id="form-actions">
            <button type="submit" class="confirm" id="edit-menu-submit">
                <span>Save</span>
            </button>
        </div>

    </form>

    <script>
    $(function () {
        <?php foreach ($this->flash('success') as $msg): ?>
            app.notify.success('<?= $msg ?>');
        <?php endforeach ?>

        <?php foreach ($this->flash('error') as $msg): ?>
            app.notify.error('<?= $msg ?>');
        <?php endforeach ?>
    });
    </script>
