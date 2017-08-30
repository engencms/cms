<?php $this->layout('layout') ?>

    <div id="hero">
        <div class="inner">

            <h1><?= $page->title ?></h1>

        </div>
    </div>


    <div id="content">

        <?= $this->parse('markdown', $page->content('body')) ?>

        <?php if ($blurbs = $page->content('blurbs', [])) : ?>

        <div id="home-blurbs">

            <?php foreach ( $blurbs as $blurb): ?>

                <div class="blurb">
                    <div class="title"><?= $blurb['title']?></div>
                    <div class="content"><?= $blurb['content']?></div>
                    <br />
                </div>

            <?php endforeach ?>

        </div>

        <?php endif ?>

    </div>
