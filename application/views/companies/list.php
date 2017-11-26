<?php

/**
 * @var $provider yii\data\ActiveDataProvider
 */

use app\widgets\Box;
use app\widgets\ButtonList;
use app\widgets\GridView;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Компании';
$this->params['breadcrumbs'][] = ['label' => 'Компании'];
?>

<h1>Компании</h1>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(['type' => 'primary']) ?>

        <?= GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                [
                    'attribute' => 'userId',
                    'value' => 'user.login'
                ],
                'name',
                'created',
                ['class' => 'app\widgets\ActionColumn']
            ]
        ]) ?>
        <?php Box::end(); ?>
    </div>
</div>


