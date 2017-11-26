<?php

namespace app\models\forms;

use app\models\User;
use yii\base\InvalidConfigException;

class UserForm extends \app\classes\Model {
    public $login;
    public $email;
    public $password;
    public $role;
    public $activity;

    public function init() {
        parent::init();

        if ($this->activity === null) {
            $this->activity = User::STATE_INACTIVE;
        }
    }

    public function rules() {
        return [
            'create' => [
                'login' => [
                    ['required', 'message' => 'Введите логин'],
                    ['string', 'length' => [3, 25], 'tooShort' => 'Логин должен содержать не менее 3 символов', 'tooLong' => 'Превышена длина строки 25 символов'],
                    ['match', 'pattern' => '/^[A-ZА-Я0-9]*$/ui', 'message' => 'Логин может содержать только буквы и цифры'],
                    ['unique', 'targetClass' => 'app\models\User', 'message' => 'Такой логин уже используется']
                ],
                'email' => [
                    ['required', 'message' => 'Введите Email'],
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки 100 символов'],
                    ['email', 'message' => 'Некорректный Email'],
                    ['unique', 'targetClass' => 'app\models\User', 'message' => 'Такой Email уже используется']
                ],
                'password' => [
                    ['string', 'length' => [5, 25], 'tooShort' => 'Пароль должен содержать не менее 5 символов', 'tooLong' => 'Превышена длина строки 25 символов'],
                ],
                'role' => [
                    'required',
                    ['in', 'range' => User::roleKeys()]
                ],
                'activity' => [
                    'boolean'
                ]
            ],
            'update' => [
                'login' => ['safe'],
                'email' => [
                    ['required', 'message' => 'Введите Email'],
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки 100 символов'],
                    ['email', 'message' => 'Некорректный Email'],
                    ['unique', 'targetClass' => 'app\models\User', 'filter' => ['!=', 'id', $this->_user->id], 'message' => 'Такой Email уже используется']
                ],
                'password' => [
                    ['string', 'length' => [5, 25], 'tooShort' => 'Пароль должен содержать не менее 5 символов', 'tooLong' => 'Превышена длина строки 25 символов'],
                ],
                'role' => [
                    'required',
                    ['in', 'range' => User::roleKeys()]
                ],
                'activity' => [
                    'boolean'
                ]
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'role' => 'Группа',
            'activity' => 'Активный',
        ];
    }

    private $_user;

    public function setUser($user) {
        if (!$user instanceof User) {
            throw new InvalidConfigException('User model must be instance of app\models\User class');
        }

        $this->_user = $user;
        $this->login = $user->login;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->role;
        $this->activity = $user->activity;
    }

    public function getUser() {
        return $this->_user;
    }

    public function onProcessCreate() {
        $this->_user->login = $this->login;
        $this->_user->email = $this->email;

        if (!$this->password) {
            $this->password = \Yii::$app->security->generateRandomString(8);
        }
        $this->_user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $this->_user->role = $this->role;
        $this->_user->activity = $this->activity;

        if (!$this->_user->save(false)) {
            throw new \Exception('Can not create user');
        }

        return true;
    }

    public function onProcessUpdate() {
        $this->_user->email = $this->email;

        if ($this->password) {
            $this->_user->password = \Yii::$app->security->generatePasswordHash($this->password);
        }

        $this->_user->role = $this->role;
        $this->_user->activity = $this->activity;

        if (!$this->_user->save(false)) {
            throw new \Exception('Can not update user');
        }

        return true;
    }
}