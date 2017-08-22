<div class="table" id="files-list">

    <div class="header">

        <div class="prop"></div>
        <div class="prop">File</div>
        <div class="prop file-info">Info</div>
        <div class="prop date">Date</div>

    </div>

    <?php foreach ($this->files() as $item): ?>

    <div class="item" data-type="<?= $item->realType() ?>">

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

            <a href="<?= $this->fileUri($item->name) ?>" class="file-selector-url">
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

    </div>

    <?php endforeach ?>

</div>
