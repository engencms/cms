
    <div class="form-item">
        <label for="<?= $id ?>"><?= $field['label'] ?? $key ?? '' ?></label>
        <textarea id="<?= $id ?>" name="<?= $name ?>" <?= $field['settings']['attributes'] ?? '' ?>><?= $this->e($value) ?></textarea>
    </div>
