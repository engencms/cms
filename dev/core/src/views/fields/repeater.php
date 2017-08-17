<?php

    if (empty($field['fields'])) {
        return;
    }

?>

    <div class="form-group sortable">

        <div class="group-title"><?= $field['label'] ?? 'Repeater' ?></div>

            <?php
            $items = is_array($value) ? count($value) : 0;

            for ($i = 0; $i < $items; $i++) :

            ?>

            <div class="group-content sortable-item">

            <?php

                foreach ($field['fields'] as $k => $f):

                    $this->insert('admin::fields/' . $f['type'], [
                        'field'    => $f,
                        'key'      => $k,
                        'value'    => $value[$i][$k] ?? ($f['default'] ?? null),
                        'name'     => "{$name}[{$k}][]",
                        'id'       => "{$id}-{$k}-{$i}",
                    ]);

                endforeach;

            ?>

            </div>

            <?php
            endfor;
            ?>

            <a href="#" id="add-field-btn" data-template="field-template-<?= $key ?>">+ Add field</a>

        </div>

        <script type="text/template" id="field-template-<?= $key ?>">
            <div class="group-content">

            <?php

            foreach ($field['fields'] as $k => $f):

                $this->insert('admin::fields/' . $f['type'], [
                    'field'    => $f,
                    'key'      => $k,
                    'value'    => null,
                    'name'     => "{$name}[{$k}][]",
                    'id'       => '',
                ]);

            endforeach;

            ?>

            </div>
        </script>

    </div>