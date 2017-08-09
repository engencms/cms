<!DOCTYPE html>
<html>
<head>
    <title>Engen Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
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
            foreach ($crumbs as $index => $crumb): ?>

                <?php if (count($crumbs) == $index + 1): ?>
                    <li class="current"><?= $crumb['label'] ?></li>
                <?php else: ?>
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
            <li class="item <?= $this->uriStart($this->route('engen.menus'), 'current') ?>"">
                <a href="<?= $this->route('engen.menus') ?>">
                    <span class="icon menus"></span>Menus
                </a>
            </li>
            <li class="item">
                <a href="#">
                    <span class="icon settings"></span>Settings
                </a>
            </li>
            </ul>

        </div>

        <div id="content">

            <?php if ($subnav = $this->section('sub-nav')): ?>
            <div id="sub-nav">
                <?= $subnav ?>
            </div>
            <?php endif ?>

            <?= $this->section('content') ?>

        </div>

    </div>

    <div id="notify"></div>

</body>
</html>