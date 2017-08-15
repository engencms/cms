<!DOCTYPE html>
<html>
<head>
    <title><?= trim($this->setting('site_name') . ' - ' . $page->title, ' - ') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?= $this->themeAsset('/main.css')?>" />
</head>
<body>

    <header id="header">
        <div class="inner">

            <div id="logo">
                <a href="/"><?= $this->setting('site_name') ?></a>
            </div>

            <?php if ($menu = $this->menu('main-menu')): ?>

            <div id="main-menu">

                <?php foreach ($menu->items as $item):
                    if ($item->page_status != 'published') continue;
                ?>

                <a href="<?= $item->link ?>" class="<?= $this->uri($item->link, 'current')?>"><?= $item->label ?></a>

                <?php endforeach ?>

            </div>

            <?php endif ?>

        </div>
    </header>


    <?= $this->section('content') ?>

    <footer id="footer">
        <?= $this->block('footer', 'copyright') ?>
    </footer>

</body>
</html>