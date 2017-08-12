<?php $this->layout('layout') ?>

    <div id="content" class="with-sidebar">

        <div id="sidebar-col">

            <?php if ($this->menu($page->key)): ?>

            <ul class="nav">

                <li class="title">Navigation</li>

                <?php foreach ($this->menu($page->key)->items as $item): ?>

                <li><a href="<?= $item->link ?>"><?= $item->label ?></a></li>

                <?php endforeach ?>

            </ul>

            <?php endif?>

        </div>

        <div id="content-col">

            <h1><?= $page->title ?></h1>

            <?= $this->parse('markdown', $page->content('body')) ?>

        </div>

    </div>
