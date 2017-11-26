<?php

/**
 * @var $model app\models\User
 */

use app\widgets\Box;
use yii\widgets\DetailView;
use app\widgets\ButtonList;

$this->title = 'Просмотр пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Yii::$app->user->returnUrl];
$this->params['breadcrumbs'][] = ['label' => 'Просмотр пользователя'];
?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin([
            'type' => 'primary',
            'footer' => ButtonList::widget([
                'items' => [
                    ['label' => 'Назад', 'url' => Yii::$app->user->returnUrl, 'options' => ['class' => 'btn-default']],
                    ['label' => 'Редактировать', 'url' => ['users/update', 'id' => $model->id], 'options' => ['class' => 'btn-primary']],
                    ['label' => 'Удалить', 'url' => ['users/delete', 'id' => $model->id], 'options' => ['class' => 'btn-danger', 'data' => ['confirm' => 'Вы уверены?']]]
                ],
                'options' => [
                    'class' => 'text-right'
                ]
            ])
        ]) ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'login',
                    'email',
                    [
                        'attribute' => 'role',
                        'value' => function($model) {
                            return $model->roleText;
                        }
                    ],
                    [
                        'attribute' => 'activity',
                        'value' => function($model) {
                            return $model->activityText;
                        }
                    ],
                    'created'
                ]
            ]) ?>
        <?php Box::end(); ?>
    </div>
</div>


