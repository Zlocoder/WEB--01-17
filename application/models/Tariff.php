<?php

namespace app\models;

class Tariff extends \app\classes\ActiveRecord {
    protected static $tableName = 'tariffs';

    protected static $timestamp = false;

    public function rules() {
        return [
            'default' => [
                'companyId' => [
                    'required',
                    ['exist', 'targetClass' => 'app\models\Company', 'targetAttribute' => 'id']
                ],
                'priceFrom' => ['required', 'double'],
                'priceTo' => ['required', 'double'],
                'widthFrom' => ['required', 'integer'],
                'widthTo' => ['required', 'integer'],
                'heightFrom' => ['required', 'integer'],
                'heightTo' => ['required', 'integer'],
                'lengthFrom' => ['required', 'integer'],
                'lengthTo' => ['required', 'integer'],
                'weightFrom' => ['required', 'integer'],
                'weightTo' => ['required', 'integer'],
                'activity' => ['required', 'boolean']
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'companyId' => 'Копания',
            'priceFrom' => 'Цена от',
            'priceTo' => 'Цена до',
            'widthFrom' => 'Ширина от',
            'widthTo' => 'Ширина до',
            'heightFrom' => 'Высота от',
            'heightTo' => 'Высота до',
            'lengthFrom' => 'Длина от',
            'lengthTo' => 'Длина до',
            'weightFrom' => 'Вес от',
            'weightTo' => 'Вес до'
        ];
    }

    public function getCompany() {
        return $this->hasOne('app\models\Company', ['id' => 'companyId']);
    }

    public function getUser() {
        return $this->hasOne('app\models\User', ['id' => 'userId'])->via('company');
    }
}