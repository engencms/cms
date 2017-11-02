<?php $this->layout('layout') ?>

    <div id="hero" style="background-image: url(<?= $page->content('hero-image') ?>)">
        <div class="inner">

            <h1><?= $page->title ?></h1>

        </div>
    </div>


    <div id="content">

        <div id="home-intro">
            <?= $this->parse('markdown', $page->content('body')) ?>
        </div>

        <?php if ($blurbs = $page->content('blurbs', [])) : ?>

        <div id="home-blurbs" class="blurbs">

            <?php foreach ($blurbs as $blurb) : ?>

                <div class="blurb">
                    <div class="icon"><span class="fa fa-<?= $blurb['icon'] ?? '' ?>"></span></div>
                    <div class="title"><?= $blurb['title'] ?? '' ?></div>
                    <div class="content"><?= $blurb['content'] ?? '&nbsp;' ?></div>
                </div>

            <?php endforeach ?>

        </div>

        <?php endif ?>

    </div>
