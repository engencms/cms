<div class="form-item">
    <label>Label</label>
    <input type="text" id="page-link-selector-label" value="<?= $this->e($data['label'] ?? '') ?>" />
</div>

<div class="form-item">
    <label>Link to page</label>
    <select id="page-link-selector-page-key">
    <option value="">Use custom URL</option>
    <?php foreach ($this->pages() as $page):
        $indent = str_repeat('&nbsp;', ($page->level * 2));
        $indent .= $indent? '&mdash; ' : '';
    ?>
        <option value="<?= $page->key ?>"><?= $indent . $this->e($page->title) ?></option>
    <?php endforeach ?>
    </select>
</div>

<div class="form-item">
    <label>Custom URL</label>
    <input type="text" id="page-link-selector-url" value="<?= $this->e($data['url'] ?? '') ?>" />
</div>


<div class="form-item">
    <label>Target</label>
    <input type="text" id="page-link-selector-target" value="<?= $this->e($data['target'] ?? '') ?>" />
</div>

<div class="form-item">
    <button type="button" id="lightbox-confirm">OK</button>
</div>