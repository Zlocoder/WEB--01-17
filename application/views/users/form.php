<?php

/**
 * @var $model app\models\forms\UserForm
 */

use app\widgets\Box;
use kartik\form\ActiveForm;
use yii\bootstrap\Html;


$this->title = $model->scenario == 'create' ? 'Новый пользователь' : "Редактирование пользователя {$model->login}";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Yii::$app->user->returnUrl];
?>

<div class="row">
    <div class="col-xs-6">
        <?php Box::begin(['header' => $this->title, 'type' => 'primary']) ?>
            <?php $form = ActiveForm::begin([
                'validateOnSubmit' => false
            ]) ?>
                <?= $form->field($model, 'login')->textInput([
                    'disabled' => $model->scenario == 'update'
                ]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password', [
                    'addon' => [
                        'append' => [
                            'content' => Html::submitButton('Новый ...', [
                                'class' => ['btn btn-flat btn-default'],
                                'name' => 'generate',
                                'value' => 1
                            ]),
                            'asButton' => true
                        ]
                    ]
                ]) ?>

                <?= $form->field($model, 'role')->dropDownList(\app\models\User::roleOptions(), ['prompt' => '']) ?>

                <?= $form->field($model, 'activity')->widget('kartik\widgets\SwitchInput') ?>

                <div class="text-right">
                    <button type="submit" class="btn btn-flat btn-primary">Сохранить</button>
                    <a href="<?= Yii::$app->user->returnUrl ?>" class="btn btn-flat btn-default">Назад</a>
                </div>
            <?php $form->end(); ?>
        <?php Box::end() ?>
    </div>
</div>

