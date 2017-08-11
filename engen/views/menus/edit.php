<?php $this->layout('admin::layout') ?>

<?php
if ($menu->id):
    $this->start('sub-nav')
?>

    <a href="<?= $this->route('engen.menus.delete') ?>" id="delete-sub-nav-btn" data-ref="<?= $menu->id ?>" data-token="<?= $this->csrfToken('delete-menu')?>">
       <span class="icon delete"></span>Delete this menu
    </a>

<?php
    $this->stop();
endif;
?>

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

            <div class="table sortable" id="menu-items-list">

                <div class="header">

                    <div class="prop menu-name">Menu label</div>
                    <div class="prop link-type">Link type</div>
                    <div class="prop link">Link</div>
                    <div class="prop target">Target</div>
                    <div class="prop"></div>

                </div>

            <?php foreach ($menu->items as $item): ?>

                <?php $this->insert('admin::menus/partials/item', ['item' => $item]) ?>

            <?php endforeach ?>

                <div class="item" id="menu-item-add-row">

                    <div class="prop"><a href="#" id="add-menu-item-btn">+ Add a menu item</a></div>
                    <div class="prop"></div>
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


    <script type="text/template" id="menu-item-template">

        <?php $this->insert('admin::menus/partials/item') ?>

    </script>


    <script>
    $(function () {
        var sortable = new Sortable(document.getElementById('menu-items-list'), {
            sort: true,  // sorting inside list
            delay: 0, // time in milliseconds to define when the sorting should start
            disabled: false, // Disables the sortable if set to true.
            store: null,  // @see Store
            animation: 150,  // ms, animation speed moving items when sorting, `0` — without animation
            handle: ".item",  // Drag handle selector within list items
            draggable: ".item",  // Specifies which items inside the element should be draggable
            scroll: true, // or HTMLElement
        });

        $('#menu-items-list').on('change', '.link-type-select', function (e) {
            var val     = $(this).val();
            var $parent = $(this).closest('.item');

            $('.link-type-action', $parent).removeClass('selected');
            $('.link-type-' + val, $parent).addClass('selected');
        });

        $('#menu-items-list').on('click', '.remove-item-btn', function (e) {
            e.preventDefault();
            if (confirm('Are you sure you want to completely remove this item?')) {
                $(this).closest('.item').remove();
            }
        });

        $('#add-menu-item-btn').on('click', function (e) {
            e.preventDefault();

            $($('#menu-item-template').html()).insertBefore('#menu-item-add-row');
        });
    });
    </script>
