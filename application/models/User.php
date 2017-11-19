<?php

namespace app\models;

class User extends \app\classes\ActiveRecord implements \yii\web\IdentityInterface {
    protected static $tableName = 'users';

    const ROLE_GUEST = 'guest';
    const ROLE_USER = 'user';
    const ROLE_SUPPORT = 'support';
    const ROLE_ADMIN = 'admin';

    const INACTIVE = 0;
    const ACTIVE = 1;

    public function init() {
        if (!$this->role) {
            $this->role = self::ROLE_GUEST;
        }
    }

    public function rules() {
        return [
            'default' => [
                'login' => [
                    'required',
                    ['string', 'max' => 25],
                    'unique'
                ],
                'email' => [
                    'required',
                    ['string', 'max' => 100],
                    'unique',
                    'email'
                ],
                'password' => [
                    'required',
                    ['string', 'length' => 60]
                ],
                'role' => [
                    'required',
                    ['in', 'range' => [self::ROLE_USER, self::ROLE_SUPPORT, self::ROLE_ADMIN]]
                ],
                'active' => [
                    'boolean',
                ],
                'created' => ['required']
            ],
            'safe' => ['login', 'email', 'password', 'role', 'active', 'created']
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'role' => 'Группа',
            'active' => 'Активный',
            'created' => 'Добавлен'
        ];
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return null;
    }

    public function validateAuthKey($authKey) {
        return false;
    }

    public function getRoleText() {
        switch ($this->role) {
            case self::ROLE_GUEST : return 'Гость';
            case self::ROLE_USER : return 'Пользователь';
            case self::ROLE_SUPPORT : return 'Потдержка';
            case self::ROLE_ADMIN : return 'Администратор';
        }

        return null;
    }

    public static function roleOptions() {
        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_SUPPORT => 'Потдержка',
            self::ROLE_ADMIN => 'Администратор',
        ];
    }

    public static function find($activeOnly = true) {
        $query = parent::find();

        if ($activeOnly) {
            $query->where(['active' => 1]);
        }

        return $query;
    }
}