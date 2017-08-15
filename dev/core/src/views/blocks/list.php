<?php $this->layout('admin::layout') ?>

<?php $this->start('sub-nav') ?>

    <a href="<?= $this->route('engen.blocks.new') ?>" class="<?= $this->uriStart($this->route('engen.blocks.new'), 'current') ?>">
       <span class="icon add"></span>Add new block
    </a>

<?php $this->stop() ?>

    <div class="content-inner">

        <div class="table" id="blocks-list">

            <div class="header">

                <div class="prop">Name</div>
                <div class="prop key">Key</div>
                <div class="prop template">Template</div>
                <div class="prop date">Created</div>

            </div>

            <?php foreach ($this->blocks() as $item): ?>

            <div class="item">

                <div class="prop name">
                    <a href="<?= $this->route('engen.blocks.edit', [$item->id]) ?>">
                        <?= $this->e($item->name) ?>
                    </a>
                </div>

                <div class="prop key">
                    <?= $this->e($item->key) ?>
                </div>

                <div class="prop key">
                    <?= $this->e($item->definition) ?>
                </div>

                <div class="prop date"><?= $item->date('created', 'Y-m-d H:i:s') ?></div>

            </div>

            <?php endforeach ?>

        </div>

    </div>
