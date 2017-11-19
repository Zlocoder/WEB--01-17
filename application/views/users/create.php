<?php

/**
 * @var $model app\models\forms\UserForm
 */

use app\widgets\Box;
use app\widgets\ButtonList;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = ['label' => 'Новый пользаватель']
?>

<div class="row">
    <div class="col-xs-8">
        <?php Box::begin(['type' => 'primary']) ?>
            <?php $form = ActiveForm::begin([]) ?>

                <?= $form->field($model, 'login') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password') ?>

                <?= $form->field($model, 'role')->dropDownList(\app\models\User::roleOptions(), [
                    'prompt' => '',
                    'disabled' => !Yii::$app->user->can('users/update-role')
                ]) ?>

                <?= $form->field($model, 'active')->checkbox([
                    'disabled' => !Yii::$app->user->can('users/update-activity')
                ]) ?>

                <div class="text-right">
                    <button type="submit" class="btn btn-flat btn-primary">Сохранить</button>
                </div>

            <?php $form->end(); ?>
        <?php Box::end() ?>
    </div>
</div>