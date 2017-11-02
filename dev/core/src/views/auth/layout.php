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
<body class="login">

    <div id="login-wrapper">

        <?= $this->section('content') ?>

    </div>

    <div id="notify"></div>

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