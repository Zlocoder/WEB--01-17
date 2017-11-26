<?php

namespace app\models;

class Company extends \app\classes\ActiveRecord {
    protected static $tableName = 'companies';

    protected static $activity = false;

    public function rules() {
        return [
            'default' => [
                'userId' => [
                    'required',
                    ['exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'id'],
                    ['unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'id']
                ],
                'name' => [
                    'required',
                    ['string', 'max' => 50],
                    ['math', 'pattern' => '/^[A-ZА-Я0-9 -]$/'],
                    'unique'
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'userId' => 'Пользователь',
            'name' => 'Название',
            'created' => 'Дата создания'
        ];
    }

    public function getUser() {
        return $this->hasOne('app\models\User', ['id' => 'userId']);
    }
}