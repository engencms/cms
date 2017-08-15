<?php foreach ($fields as $key => $field): ?>


    <?php
    $this->insert('admin::fields/' . $field['type'], [
        'label'    => $field['label'] ?? $key,
        'key'      => $key,
        'value'    => $content[$key] ?? ($field['default'] ?? null),
        'settings' => $field['settings'] ?? [],
        'name'     => 'field['.$key.']',
        'id'       => 'frm-field-' . $key,
    ]);
    ?>


<?php endforeach ?>