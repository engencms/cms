<?php $this->layout('admin::layout') ?>

<?php $this->start('sub-nav') ?>

    <a href="#" id="add-files-btn" data-url="<?= $this->route('engen.files.upload') ?>" data-token="<?= $this->csrfToken('upload-files') ?>">
       <span class="icon add"></span>Add file(s)
    </a>

<?php $this->stop() ?>

    <div class="content-inner">

        <div class="table" id="files-list">

            <div class="header">

                <div class="prop"></div>
                <div class="prop">File</div>
                <div class="prop file-info">Info</div>
                <div class="prop date">Date</div>
                <div class="prop"></div>

            </div>

            <?php foreach ($this->files() as $item): ?>

            <div class="item">

                <div class="prop thumb">
                    <?php if($item->realType() == 'image'): ?>

                        <a href="<?= $this->fileUri($item->name) ?>" target="_blank">
                            <img src="<?= $this->fileUri($item->name) ?>" />
                        </a>

                    <?php else: ?>

                        <span class="icon <?= $item->realType() ?>"></span>

                    <?php endif ?>
                </div>

                <div class="prop name">

                    <a href="<?= $this->fileUri($item->name) ?>" target="_blank">
                        <?= $item->name ?>
                    </a>

                    <div class="path">
                        <?= $this->fileUri($item->name) ?>
                    </div>

                </div>

                <div class="prop file-info">

                    <?= $item->size() ?>

                    <div class="type">
                        <?= ucfirst($item->realType()) ?>

                        <?php if ($item->realType() == 'image'): ?>
                        <span class="dimensions">
                            (<?= implode('x', $this->imageDimensions($item->name)) ?>)
                        </span>
                        <?php endif ?>
                    </div>

                </div>

                <div class="prop date"><?= $item->date('created', 'Y-m-d H:i:s') ?></div>

                <div class="prop delete delete">
                    <a href="<?= $this->route('engen.files.delete') ?>" class="delete-file-btn" data-ref="<?= $item->name ?>" data-token="<?= $this->csrfToken('delete-file') ?>">X</a>
                </div>

            </div>

            <?php endforeach ?>

        </div>

    </div>
