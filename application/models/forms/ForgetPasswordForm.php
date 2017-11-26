<?php

namespace app\models\forms;

use app\models\User;

class ForgetPasswordForm extends \app\classes\Model {
    public $email;

    public function rules () {
        return [
            'default' => [
                'email' => [
                    ['required', 'message' => 'Введите email'],
                    ['email', 'message' => 'Некорректный Email'],
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки (100 символов)'],
                    ['exist', 'targetClass' => 'app\models\user', 'message' => 'Такой Email не зарегестрирован']
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Email'
        ];
    }

    public function onProcess() {
        $user = User::findOne(['email' => $this->email]);
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $password = \Yii::$app->security->generateRandomString();
            $user->password = \Yii::$app->security->generatePasswordHash($password);
            if (!$user->save(false)) {
                throw new \Exception('Не удалось изменить пароль');
            }

            $mail = \Yii::$app->mailer->compose('forget-password')
                ->setFrom(\Yii::$app->params['systemEmail'])
                ->setSubject('Восстановление пароля');

            if (!$mail->send()) {
                throw new \Exception('Не удалось отправить письмо');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $error) {
            $transaction->rollBack();
            throw $error;
        }
    }
}