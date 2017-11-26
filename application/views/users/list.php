<?php

/**
 * @var $filter app\models\filters\UsersFilter
 * @var $filterActive bool
 * @var $filterReset string
 */

use app\widgets\Box;
use app\widgets\ButtonList;
use app\widgets\GridView;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи'];
?>

<h1>Пользователи</h1>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'layout' => 'inline',
            'fieldConfig' => [
                'labelOptions' => [
                    'class' => ''
                ],
                'options' => [
                    'class' => 'form-group form-group-sm'
                ]
            ],
            'enableClientValidation' => false,
            'options' => [
                'class' => 'filter'
            ]
        ]) ?>

            <?php Box::begin([
                'type' => 'primary',
                'header' => ButtonList::widget([
                    'items' => [
                        ['label' => 'Добавить', 'url' => ['users/create'], 'icon' => 'user-plus', 'options' => ['class' => 'btn-flat btn-success']]
                    ]
                ])
            ]) ?>
                <div class="row with-border">
                    <?= $form->field($filter, 'role')->label('')->widget('app\widgets\SubmitGroup', [
                        'defaultButton' => true,
                        'items' => User::roleOptions(),
                        'submitOptions' => [
                            'class' => 'btn-sm'
                        ]
                    ]) ?>

                    <?= $form->field($filter, 'login') ?>

                    <?= $form->field($filter, 'email') ?>

                    <?= $form->field($filter, 'activity')->label('')->widget('app\widgets\SubmitGroup', [
                        'items' => [
                            User::STATE_ACTIVE => 'Активные',
                            User::STATE_INACTIVE => 'Неактивные'
                        ],
                        'submitOptions' => [
                            'class' => 'btn-sm'
                        ]
                    ]) ?>

                    <div class="form-group pull-right">
                        <a class="btn btn-flat btn-sm btn-default" href="<?= $filterReset ?>">Сбросить</a>
                    </div>
                </div>

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
                        ['class' => 'app\widgets\ActionColumn']
                    ]
                ]) ?>
            <?php Box::end(); ?>
        <?php $form->end(); ?>
    </div>
</div>


