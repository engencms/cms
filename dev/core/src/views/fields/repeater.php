<?php

    if (empty($field['fields'])) {
        return;
    }

?>

    <div class="form-group sortable open" id="group-<?= $groupId = uniqid() ?>">

        <div class="group-title">
            <a href="#" class="group-expand arrow">
                <span class="icon"></span>
            </a>
            <span class="label"><?= $field['label'] ?? 'Repeater' ?></span>
        </div>

        <?php
        $items = is_array($value) ? count($value) : 0;

        for ($i = 0; $i < $items; $i++) :

        ?>

        <div class="group-content sortable-item">

            <div class="group-actions sortable-handle">
                <a href="#" class="group-item-remove">
                    <span class="icon"></span>
                </a>
            </div>

            <div class="group-inner">

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

        </div>

        <?php
        endfor;
        ?>

        <div class="add-group-item-container">
            <a href="#" id="add-field-btn" data-template="field-template-<?= $key ?>" data-group-id="group-<?= $groupId ?>"><span class="icon"></span>Add field</a>
        </div>

    </div>

        <script type="text/template" id="field-template-<?= $key ?>">
            <div class="group-content sortable-item">

                <div class="group-actions sortable-handle">
                    <a href="#" class="group-item-remove">
                        <span class="icon"></span>
                    </a>
                </div>

                <div class="group-inner">

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

            </div>
        </script>

    </div>