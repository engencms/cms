<?php $this->layout('admin::layout') ?>

<?php $this->start('sub-nav') ?>

    <a href="<?= $this->route('engen.users.new') ?>" class="<?= $this->uriStart($this->route('engen.users.new'), 'current') ?>">
       <span class="icon add"></span>Add new user
    </a>

<?php $this->stop() ?>

    <div class="content-inner">

        <div class="table" id="users-list">

            <div class="header">

                <div class="prop"></div>
                <div class="prop">Username</div>
                <div class="prop email">E-mail</div>
                <div class="prop date">Created</div>

            </div>

            <?php foreach ($this->users() as $item): ?>

            <div class="item <?= $this->isMe($item->id) ? 'me' : ''?>">

                <div class="prop thumb">
                    <img src="<?= $this->gravatar($item->email, 35) ?>" class="user-avatar" />
                </div>

                <div class="prop name">

                    <a href="<?= $this->route('engen.users.edit', [$item->id]) ?>">
                        <?= $this->e($item->username) ?>
                    </a>

                    <div class="real-name">
                        <?= $this->e(trim($item->first_name . ' ' . $item->last_name)) ?>
                    </div>

                </div>

                <div class="prop email">
                    <?= $this->e($item->email) ?>
                </div>

                <div class="prop date"><?= $item->date('created', 'Y-m-d H:i:s') ?></div>

            </div>

            <?php endforeach ?>

        </div>

    </div>
