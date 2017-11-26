<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php $this->head() ?>
</head>

<!--
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
    <header class="main-header">
        <a href="/" class="logo">
            <span class="logo-mini"><b>A</b>LT</span>
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Свернуть меню</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="http://placehold.it/160x160" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= Yii::$app->user->login ?></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <p>
                                        <?= Yii::$app->user->login ?> - <?= Yii::$app->user->roleText ?>
                                        <small>C <?= Yii::$app->user->created ?></small>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= Url::to(['profile/index']) ?>" class="btn btn-default btn-flat">Профиль</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= Url::to(['auth/logout']) ?>" class="btn btn-default btn-flat">Выйти</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <?= \yiister\adminlte\widgets\Menu::widget([
                    "items" => $this->params['menu'],
                ]
            )
            ?>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?= \yii\widgets\Breadcrumbs::widget([
                        'encodeLabels' => false,
                        'homeLink' => [
                            'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Главная',
                            'url' => '/',
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ])
                ?>
            <?php endif; ?>

            <?= \yiister\adminlte\widgets\FlashAlert::widget() ?>
        </section>

        <section class="content">
            <?= $content ?>
        </section>
    </div>

    <footer class="main-footer">
        <strong><?= Yii::powered() ?></strong>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
