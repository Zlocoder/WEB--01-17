<?php

/**
 * @var $provider yii\data\ActiveDataProvider
 */

use app\widgets\Box;
use app\widgets\ButtonList;
use app\widgets\GridView;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Мои тарифы';
$this->params['breadcrumbs'][] = ['label' => 'Мои тарифы'];
?>

<h1>Мои тарифы</h1>

<div class="row">
    <div class="col-xs-12">
            <?php Box::begin([
                'type' => 'primary',
                'header' => ButtonList::widget([
                    'items' => [
                        ['label' => 'Добавить', 'url' => ['tariffs/create'], 'icon' => 'plus', 'options' => ['class' => 'btn-flat btn-success']]
                    ]
                ])
            ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $provider,
                    'columns' => [
                        'priceFrom',
                        'priceTo',
                        'widthFrom',
                        'widthTo',
                        'heightFrom',
                        'heightTo',
                        'lengthFrom',
                        'lengthTo',
                        'weightFrom',
                        'weightTo',
                        ['class' => 'app\widgets\ActionColumn']
                    ]
                ]) ?>
            <?php Box::end(); ?>
    </div>
</div>


