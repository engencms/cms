    <script type="text/template" id="field-template-<?= $id ?>">

        <div class="group-content sortable-item new">

            <div class="group-actions sortable-handle">
                <a href="#" class="group-item-remove">
                    <span class="icon"></span>
                </a>
            </div>

            <div class="group-inner">

            <?php

                $this->insert('admin::fields/show-fields', [
                    'fields'   => $fields,
                    'content'  => [],
                    'name'     => $name,
                    'id'       => $id,
                ]);

            ?>

            </div>

        </div>

    </script>
