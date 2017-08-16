
    <div class="form-item">
        <label for="<?= $id ?>"><?= $field['label'] ?? $key ?? '' ?></label>
        <input type="text" id="<?= $id ?>" name="<?= $name ?>" value="<?= $this->e($value) ?>" />
    </div>
