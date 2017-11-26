<?php

/**
 * @var $model app\models\forms\RegistrationForm
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<p class="login-box-msg">Регистрация</p>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'confirm')->passwordInput() ?>

<?= $form->field($model, 'company') ?>

<div class="row">
    <div class="col-xs-12 text-right">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Зарегистрироваться</button>
    </div>
</div>
<?php $form->end() ?>

