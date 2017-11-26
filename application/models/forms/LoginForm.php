<?php

namespace app\models\forms;

use app\models\User;

class LoginForm extends \app\classes\Model {
    public $email;
    public $password;

    public function rules() {
        return [
            'default' => [
                'email' => [
                    ['required', 'message' => 'Введите Email'],
                    ['email', 'message' => 'Некорректный Email']
                ],
                'password' => [
                    ['required', 'message' => 'Введите пароль'],
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'password' => 'Пароль'
        ];
    }

    public function onProcess() {
        if ($user = User::findOne(['email' => $this->email, 'activity' => 1])) {
            if (\Yii::$app->security->validatePassword($this->password, $user->password)) {
                if (!\Yii::$app->user->login($user)) {
                    throw new \Exception('Can not login user');
                }

                return true;
            }
        }

        $this->addError('password', 'Неверный email или пароль');

        return false;
    }
}