<?php $this->layout('layout') ?>

    <div id="content" class="with-sidebar">

        <div id="sidebar-col">


        </div>

        <div id="content-col">

            <h1><?= $page->title ?></h1>

            <?= $this->parse('markdown', $page->content('body')) ?>

        </div>

    </div>
