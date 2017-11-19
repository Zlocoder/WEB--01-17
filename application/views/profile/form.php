<?php

/**
 * @var $model app\models\forms\ProfileForm
 */

use yii\bootstrap\ActiveForm;
use yiister\adminlte\widgets\Box;
use yii\web\AssetManager;
use yii\web\View;

$this->title = 'Личная информация';
$this->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@app/views/assets') . '/js/profile-form.js');
?>

<div class="row">
    <div class="col-xs-6">
        <?php Box::begin() ?>
            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'login')->textInput(['disabled' => true]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'oldPassword')->passwordInput() ?>

                <?= $form->field($model, 'newPassword')->passwordInput() ?>

                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

                <?= $form->field($model, 'role')->dropDownList(\app\models\User::roleOptions(), ['disabled' => true]) ?>

                <div class="text-center">
                    <button type="submit" class="">Сохранить</button>
                </div>
            <?php $form->end() ?>
        <?php Box::end() ?>
    </div>
</div>
