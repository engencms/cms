<?php
$id   = $id ?? 'frm-field';
$name = $name ?? 'field';

foreach ($fields as $key => $field):
?>


    <?php
    $this->insert('admin::fields/' . $field['type'], [
        'field'    => $field,
        'key'      => $key,
        'value'    => $content[$key] ?? ($field['default'] ?? null),
        'name'     => $name . "[{$key}]",
        'id'       => $id . '-' . $key,
    ]);
    ?>


<?php
endforeach;
?>