<?php $this->layout('layout') ?>

    <div id="hero">
        <div class="inner">

            <h1><?= $page->title ?></h1>

        </div>
    </div>


    <div id="content">

        <?= $this->parse('markdown', $page->content('body')) ?>

    </div>
