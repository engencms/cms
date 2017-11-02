<?php
$id   = $id ?? 'frm-field';
$name = $name ?? 'field';


foreach ($fields as $key => $field) :
?>


    <?php
    $this->insert($this->fieldView($field['type']), [
        'field'    => $field,
        'key'      => $key,
        'value'    => $content[$key] ?? null,
        'name'     => $name . "[{$key}]",
        'id'       => $id . '-' . $key,
    ]);
    ?>


<?php
endforeach;
