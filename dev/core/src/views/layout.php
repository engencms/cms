<!DOCTYPE html>
<html>
<head>
    <title>Engen Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->adminAsset('/simplemde.css') ?>" />
    <script src="<?= $this->adminAsset('/simplemde.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= $this->adminAsset('/main.css') ?>" />
    <script src="<?= $this->adminAsset('/main.js') ?>"></script>
</head>
<body>

    <div id="header">

        <div id="logo">
            <a href="<?= $this->route('engen.dashboard') ?>">Engen CMS</a>
        </div>

        <div id="bread-crumbs">

            <ul>
            <?php
            $crumbs = $this->breadCrumbs('engen');
            foreach ($crumbs as $index => $crumb) : ?>

                <?php if (count($crumbs) == $index + 1) : ?>
                    <li class="current"><?= $crumb['label'] ?></li>
                <?php else : ?>
                    <li><a href="<?= $crumb['uri'] ?>"><?= $crumb['label'] ?></a></li>
                <?php endif ?>

            <?php
            endforeach;
            ?>
            </ul>

        </div>

    </div>


    <div id="wrapper">

        <div id="main-nav">

            <ul class="group">
            <li class="title">Content</li>
            <li class="item <?= $this->uriStart($this->route('engen.pages'), 'current') ?>">
                <a href="<?= $this->route('engen.pages') ?>">
                    <span class="icon pages"></span>Pages
                </a>
            </li>
            <li class="item <?= $this->uriStart($this->route('engen.blocks'), 'current') ?>">
                <a href="<?= $this->route('engen.blocks') ?>">
                    <span class="icon blocks"></span>Blocks
                </a>
            </li>
            <li class="item <?= $this->uriStart($this->route('engen.files'), 'current') ?>">
                <a href="<?= $this->route('engen.files') ?>">
                    <span class="icon files"></span>Files
                </a>
            </li>
            <li class="item <?= $this->uriStart($this->route('engen.menus'), 'current') ?>">
                <a href="<?= $this->route('engen.menus') ?>">
                    <span class="icon menus"></span>Menus
                </a>
            </li>
            <li class="item <?= $this->uriStart($this->route('engen.settings'), 'current') ?>">
                <a href="<?= $this->route('engen.settings') ?>">
                    <span class="icon settings"></span>Settings
                </a>
            </li>
            </ul>

            <ul class="group">
            <li class="title">Actions</li>
            <li class="item">
                <a href="<?= $this->route('engen.build') ?>" id="build-btn">
                    <span class="icon play"></span>Build
                </a>
            </li>
            <!--
            <li class="item">
                <a href="<?= $this->route('engen.import-export') ?>" id="build-btn">
                    <span class="icon database"></span>Import / Export
                </a>
            </li>
            </ul>
            -->

            <ul class="group">
            <li class="title">Users</li>
            <li class="item <?= $this->uriStart($this->route('engen.users'), 'current') ?>">
                <a href="<?= $this->route('engen.users') ?>">
                    <span class="icon users"></span>Users
                </a>
            </li>
            <li class="item">
                <a href="<?= $this->route('engen.logout') ?>">
                    <span class="icon logout"></span>Log out
                </a>
            </li>
            </ul>

        </div>

        <div id="content">

            <?php if ($subnav = $this->section('sub-nav')) : ?>
            <div id="sub-nav">
                <?= $subnav ?>
            </div>
            <?php endif ?>

            <?= $this->section('content') ?>

        </div>

    </div>

    <div id="lightbox">
        <div id="lightbox-inner">
            <div id="lightbox-content"></div>
        </div>
    </div>
    <div id="notify"></div>

    <?php
    foreach ($this->fieldTemplates() as $field) :
        $this->insert($field['template'], $field['data']);
    endforeach;
    ?>

    <script>
    $(function () {
        <?php foreach ($this->flash('success') as $msg) : ?>
            app.notify.success('<?= $msg ?>');
        <?php endforeach ?>

        <?php foreach ($this->flash('error') as $msg) : ?>
            app.notify.error('<?= $msg ?>');
        <?php endforeach ?>
    });
    </script>

</body>
</html>