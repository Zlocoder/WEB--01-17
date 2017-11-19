<?php

namespace app\models\filters;

use app\models\User;
use yii\data\ActiveDataProvider;

class UsersFilter extends \app\classes\Model {
    public $role;
    public $login;
    public $email;

    public function rules() {
        return [
            'default' => [
                'role' => [
                    ['in', 'range' => [User::ROLE_USER, USER::ROLE_SUPPORT, User::ROLE_ADMIN]]
                ],
                'login' => [
                    ['string', 'max' => 25, 'tooLong' => 'Превышена длина строки (25 смиволов)']
                ],
                'email' => [
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки (25 смиволов)']
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'role' => 'Группа'
        ];
    }

    public function getProvider() {
        $this->validate();

        $query = User::find();

        if (!$this->getErrors('login')) {
            $query->andFilterWhere(['like', 'login', $this->login]);
        }

        if (!$this->getErrors('email')) {
            $query->andFilterWhere(['like', 'email', $this->login]);
        }

        if (!$this->getErrors('role')) {
            $query->andFilterWhere(['role' => $this->role]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeParam' => false,
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'created' => SORT_DESC
                ],
                'attributes' => [
                    'login',
                    'email',
                    'role',
                    'created'
                ]
            ]
        ]);
    }
}