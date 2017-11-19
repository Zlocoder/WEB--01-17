<?php

/**
 * @var $filter app\models\filters\UsersFilter
 * @var $filterActive bool
 * @var $filterReset string
 */

use app\widgets\Box;
use app\widgets\ButtonList;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи'];
?>

<div class="row">
    <div class="col-xs-9">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'layout' => 'inline',
            'fieldConfig' => [
                'labelOptions' => [
                    'class' => ''
                ]
            ],
            'enableClientValidation' => false
        ]) ?>

            <?php Box::begin([
                'header' => 'Фильтр пользователей',
                'expandable' => !$filterActive,
                'collapsable' => $filterActive,
                'type' => $filterActive ? $filter->errors ? 'danger' : 'primary' : 'default'
            ]) ?>
                    <?= $form->field($filter, 'login') ?>

                    <?= $form->field($filter, 'email') ?>

                    <?= $form->field($filter, 'role')->dropDownList(\app\models\User::roleOptions(), ['prompt' => '']) ?>

                    <div class="buttons">
                        <button type="submit" class="btn btn-flat btn-primary">Применить</button>

                        <?php if ($filterReset) { ?>
                            <a class="btn btn-flat btn-default" href="<?= $filterReset ?>">Сбросить</a>
                        <?php } else { ?>
                            <button class="btn btn-flat btn-default">Сбросить</button>
                        <?php } ?>
                    </div>
            <?php Box::end() ?>
        <?php $form->end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin([
            'type' => 'primary',
            'header' => ButtonList::widget([
                'items' => [
                    ['label' => 'Добавить', 'url' => ['users/create'], 'icon' => 'user-plus', 'options' => ['class' => 'btn-flat btn-success']]
                ]
            ])
        ]) ?>
            <?= GridView::widget([
                'dataProvider' => $filter->provider,
                'columns' => [
                    'login',
                    'email',
                    [
                        'attribute' => 'role',
                        'value' => 'roleText'
                    ],
                    'created',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}',
                        'visibleButtons' => [
                            'view' => function($model) {
                                return \Yii::$app->user->can('users/view', ['id' => $model->id]);
                            },
                            'update' => function($model) {
                                return \Yii::$app->user->can('users/update', ['id' => $model->id]);
                            },
                            'delete' => function($model) {
                                return \Yii::$app->user->can('users/delete', ['id' => $model->id]);
                            }
                        ]
                    ]
                ]
            ]) ?>
        <?php Box::end(); ?>
    </div>
</div>


