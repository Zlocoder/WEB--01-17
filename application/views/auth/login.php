<?php

/**
 * @var $model app\models\forms\LoginForm
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<p class="login-box-msg">Войдите чтобы начать работу</p>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="row">
        <div class="col-xs-8">
            <a href="<?= Url::to(['forget-password']) ?>" class="forget-password">Забыл пароль</a><br>
        </div>
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
        </div>
    </div>
<?php $form->end() ?>

