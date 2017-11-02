    <script type="text/template" id="field-template-<?= $id ?>">

        <div class="group-content sortable-item new">

            <div class="group-actions sortable-handle">
                <a href="#" class="group-item-remove">
                    <span class="icon"></span>
                </a>
            </div>

            <div class="group-inner">

            <?php
            foreach ($fields as $key => $field) :
                $this->insert($this->fieldView($field['type']), [
                    'field'    => $field,
                    'key'      => $key,
                    'value'    => null,
                    'name'     => "{$name}[{$key}][]",
                    'id'       => $id,
                ]);
            endforeach;
            ?>

            </div>

        </div>

    </script>
