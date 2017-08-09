

    <div class="item">

        <div class="prop menu-name">
            <input type="text" value="<?= $item->label ?? null ?>" name="item[label][]" />
        </div>

        <div class="prop link-type">
            <select class="link-type-select">
                <option value="page" <?= isset($item) && $item->page_id ? 'selected' : '' ?>>Link to page</option>
                <option value="custom" <?= isset($item) && !$item->page_id ? 'selected' : '' ?>>Custom</option>
            </select>
        </div>

        <div class="prop link">
            <div class="link-type-page link-type-action hide <?= !isset($item) || $item->page_id ? 'selected' : ''?>">
                <select name="item[page_id][]">
                    <?php $this->pageOptions($item->page_id ?? 0, $item->page_id ?? 0) ?>
                </select>
            </div>
            <div class="link-type-custom link-type-action hide <?= isset($item) && !$item->page_id ? 'selected' : ''?>">
                <input type="text" value="<?= isset($item) && !$item->page_id ? $item->link : '' ?>" name="item[link][]" />
            </div>
        </div>

        <div class="prop target">
            <select name="item[target][]">
                <option value="" <?= isset($item) && $item->target != '_blank' ? 'selected' : '' ?>>Self</option>
                <option value="_blank" <?= isset($item) && $item->target == '_blank' ? 'selected' : '' ?>>New window/tab</option>
            </select>
        </div>

        <div class="prop delete">
            <a href="#" class="remove-item-btn">X</a>
        </div>

    </div>
