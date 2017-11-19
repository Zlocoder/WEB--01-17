<?php

namespace app\models\forms;

use app\models\User;
use yii\web\ForbiddenHttpException;

class UserForm extends \app\classes\Model {
    public $login;
    public $email;
    public $password;
    public $role;
    public $active;

    public function rules() {
        return [
            'create' => [
                'login' => [
                    ['required', 'message' => 'Введите логин'],
                    ['string', 'length' => [3, 25], 'tooShort' => 'Логин должен содержать не менее 3 символов', 'tooLong' => 'Превышена длина строки (25 символов)'],
                    ['match', 'pattern' => '/^[A-ZА-Я0-9]*$/ui', 'message' => 'Логин может содержать только буквы и цифры'],
                    ['unique', 'targetClass' => 'app\models\User']
                ],
                'email' => [
                    ['required', 'message' => 'Введите Email'],
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки (100 символов)'],
                    ['email', 'message' => 'Некорректный Email'],
                    ['unique', 'targetClass' => 'app\models\User', 'message' => 'Такой Email уже зарегистрирован']
                ],
                'password' => [
                    ['required', 'message' => 'Введите пароль'],
                    ['string', 'length' => [5, 25], 'tooShort' => 'Пароль должен содержать не менее 5 символов', 'tooLong' => 'Превышена длина строки (25 символов)']
                ],
                'role' => [
                    ['required', 'message' => 'Укажите группу пользователя'],
                    ['in', 'range' => [User::ROLE_USER, USER::ROLE_SUPPORT, USER::ROLE_ADMIN]]
                ],
                'active' => [
                    ['boolean', 'message' => 'Некорректное значение активности']
                ]
            ],
        ];
    }

    private $_user;

    public function setUser($user) {
        $this->_user = $user;
        $this->login = $user->login;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->active = $user->active;
    }

    public function getUser() {
        return $this->_user;
    }

    public function process() {
        if ($this->validate()) {
            switch($this->scenario) {
                case 'create' :
                    $this->_user->login = $this->login;
                    $this->_user->email = $this->email;
                    $this->_user->password = \Yii::$app->security->generatePasswordHash($this->password);
                    $this->_user->role = $this->role;
                    $this->_user->active = $this->active;

                    if (!$this->_user->save(false)) {
                        throw new \Exception('Can not create user');
                    }

                    return true;
            }
        }
    }
}