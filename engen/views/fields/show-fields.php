<?php foreach ($fields as $key => $field): ?>


    <?php
    #if (!isset($field['type']) || !$this->exists('admin::fields/' . $field['type'])):
    #    continue;
    #endif;

    $this->insert('admin::fields/' . $field['type'], [
        'label'    => $field['label'] ?? $key,
        'key'      => $key,
        'value'    => $content[$key] ?? ($field['default'] ?? null),
        'settings' => $field['settings'] ?? [],
    ]);
    ?>


<?php endforeach ?>