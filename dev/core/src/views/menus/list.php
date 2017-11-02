<?php $this->layout('admin::layout') ?>

<?php $this->start('sub-nav') ?>

    <a href="<?= $this->route('engen.menus.new') ?>" class="<?= $this->uriStart($this->route('engen.menus.new'), 'current') ?>">
       <span class="icon add"></span>Add new menu
    </a>

<?php $this->stop() ?>

    <div class="content-inner">

        <div class="table">

            <div class="header">

                <div class="prop title">Name</div>
                <div class="prop key">Key</div>
                <div class="prop items">Menu items</div>

            </div>


        <?php foreach ($this->menus() as $item) : ?>

            <div class="item">

                <div class="prop title">
                    <a href="<?= $this->route('engen.menus.edit', [$item->id]) ?>"><?= $item->name ?></a>
                </div>
                <div class="prop key discreet"><?= $item->key ?></div>
                <div class="prop items"><?= count($item->items) ?></div>

            </div>

        <?php endforeach ?>

        </div>

    </div>