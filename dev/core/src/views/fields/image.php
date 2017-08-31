
    <div class="form-item">
        <label for="<?= $id ?>"><?= $field['label'] ?? $key ?? '' ?></label>
        <input type="hidden" id="<?= $id ?>" class="image-input" name="<?= $name ?>" value="<?= $this->e($value) ?>" />

        <div class="field-image-container">
            <div class="preview-container <?= !$value ? 'no-image' : '" style="background-image: url(' . $value . ')' ?>">
                <a href="#" class="field-remove-image-btn">
                    <span class="fa fa-close"></span>
                </a>
            </div>

            <a href="#" class="field-select-image-btn">Select image</a>
        </div>
    </div>
