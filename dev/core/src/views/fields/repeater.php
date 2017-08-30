
    <div class="form-group sortable open" id="group-<?= $id ?>">

        <div class="group-title">
            <a href="#" class="group-expand arrow">
                <span class="icon"></span>
            </a>

            <span class="label"><?= $field['label'] ?? 'Repeater' ?></span>

            <a href="#" class="add-field-btn" data-template="field-template-<?= $id ?>" data-group-id="group-<?= $id ?>"><span class="icon"></span>Add field</a>

        </div>

        <?php if (!is_null($value)) : ?>

        <div class="group-content sortable-item">

            <div class="group-actions sortable-handle">
                <a href="#" class="group-item-remove">
                    <span class="icon"></span>
                </a>
            </div>

            <div class="group-inner">

            <?php

                $this->insert('admin::fields/show-fields', [
                    'fields'   => $field['fields'],
                    'content'  => $value[$key] ?? [],
                    'key'      => $key,
                    'name'     => $name . "[{$key}]",
                    'id'       => $id . '-' . $key,
                ]);

            ?>

            </div>

        </div>

        <?php endif ?>


    </div>

    <?php
        $this->addFieldTemplate('admin::fields/templates/repeater', [
            'fields' => $field['fields'],
            'id'     => $id,
            'name'   => $name,
            'value'  => $value,
        ]);
    ?>

