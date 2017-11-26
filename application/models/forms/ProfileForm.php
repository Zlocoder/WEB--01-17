<?php

namespace app\models\forms;

class ProfileForm extends \app\classes\Model {
    public $email;
    public $oldPassword;
    public $newPassword;
    public $confirmPassword;

    public function init() {
        $this->email = \Yii::$app->user->email;
    }

    public function rules() {
        return [
            'default' => [
                'login' => ['safe'],
                'email' => [
                    ['required', 'message' => 'Введите Email'],
                    ['email', 'message' => 'Некорректный Email'],
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки (100 символов)'],
                    ['unique', 'targetClass' => 'app\models\User', 'filter' => ['!=', 'id', \Yii::$app->user->id], 'message' => 'Такой Email уже зарегистрирован']
                ],
                'oldPassword' => [
                    ['string', 'length' => [5, 25], 'tooShort' => 'Пароль должен содержать не менее 5 символов', 'tooLong' => 'Превышена длина строки (25 символов)']
                ],
                'newPassword' => [
                    ['required', 'when' => [$this, 'isChangePassword'], 'whenClient' => 'isChangePassword', 'message' => 'Введите новый пароль'],
                    ['string', 'length' => [5, 25], 'tooShort' => 'Пароль должен содержать не менее 5 символов', 'tooLong' => 'Превышена длина строки (25 символов)']
                ],
                'confirmPassword' => [
                    ['required', 'when' => [$this, 'isChangePassword'], 'whenClient' => 'isChangePassword', 'message' => 'Подтвердите новый пароль'],
                    ['compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают']
                ],
                'role' => ['safe']
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'confirmPassword' => 'Подтверждение пароля',
            'role' => 'Группа'
        ];
    }

    public function getLogin() {
        return \Yii::$app->user->login;
    }

    public function getRole() {
        return \Yii::$app->user->role;
    }

    public function isChangePassword() {
        return isset($this->oldPassword);
    }

    public function onProcess() {
        \Yii::$app->user->identity->email = $this->email;

        if ($this->isChangePassword()) {
            if (!\Yii::$app->security->validatePassword($this->oldPassword, \Yii::$app->user->password)) {
                $this->addError('oldPassword', 'Неверный пароль');
                return false;
            }

            \Yii::$app->user->identity->password = \Yii::$app->security->generatePasswordHash($this->newPassword);
        }

        if (!\Yii::$app->user->identity->save(false)) {
            throw new \Exception('Can not update user profile');
        }

        return true;
    }
}