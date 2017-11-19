<?php

/**
 * @var $model app\models\forms\ForgetPasswordForm
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<p class="login-box-msg">Укажите Email для восстановления пароля</p>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'email') ?>

    <div class="row">
        <div class="col-xs-7">
            <a href="<?= Url::to(['login']) ?>" class="forget-password">Назад</a><br>
        </div>
        <div class="col-xs-5">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Отправить</button>
        </div>
    </div>
<?php $form->end() ?>
