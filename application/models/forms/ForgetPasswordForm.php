<?php

namespace app\models\forms;

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

    public function process() {
        if ($this->validate()) {
            return true;
        }

        return false;
    }
}