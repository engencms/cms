<?php $this->layout('layout') ?>

    <div id="content">

        <h1><?= $page->title ?></h1>

        <?= $this->parse('markdown', $page->content('body')) ?>

    </div>
