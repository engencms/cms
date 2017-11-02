<?php $this->layout('admin::layout') ?>

<?php $this->start('sub-nav') ?>

    <a href="<?= $this->route('engen.pages.new') ?>" class="<?= $this->uriStart($this->route('engen.pages.new'), 'current') ?>">
       <span class="icon add"></span>Add new page
    </a>

<?php $this->stop() ?>

    <div class="content-inner">

    <?php
    $list = function ($parent, $list) {
        if ($children = $this->pageChildren($parent)) :
    ?>

        <ul class="list <?= $parent != 'root' ? 'sub-list' : '' ?>" id="pages-<?= $parent ?>">

            <?php if ('root' == $parent) : ?>

            <li class="row header">
                <div class="item">

                    <div class="prop title">Title</div>
                    <div class="prop key">Key</div>
                    <div class="prop date">Created</div>

                </div>
            </li>

            <?php endif ?>


        <?php foreach ($children as $item) : ?>

            <li class="row level-<?= $item->level ?>">
                <div class="item">

                    <div class="prop title">
                        <a href="<?= $this->route('engen.pages.edit', [$item->id]) ?>"><?= $this->e($item->title) ?></a>
                    </div>
                    <div class="prop key"><?= $item->key ?></div>
                    <div class="prop date"><?= $item->date('created', 'Y-m-d H:i:s') ?></div>

                </div>

                <?php $list($item->id, $list) ?>

            </li>

        <?php endforeach ?>

        </ul>

        <?php
        endif
        ?>

    <?php
    }
    ?>

    <?php $list('root', $list) ?>

    </div>