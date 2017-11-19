<?php

/**
 * @var $content string
 */

use yii\helpers\Html;

app\assets\Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title>Вход</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php $this->head() ?>
</head>

<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>LTE
    </div>

    <div class="login-box-body">
        <?= \yiister\adminlte\widgets\FlashAlert::widget() ?>

        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
