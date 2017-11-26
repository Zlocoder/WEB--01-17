<?php

namespace app\models\filters;

use app\models\User;
use yii\data\ActiveDataProvider;

class UsersFilter extends \app\classes\Model {
    public $login;
    public $email;
    public $role;
    public $activity;

    public function rules() {
        return [
            'default' => [
                'login' => [
                    ['string', 'max' => 25, 'tooLong' => 'Превышена длина строки (25 смиволов)']
                ],
                'email' => [
                    ['string', 'max' => 100, 'tooLong' => 'Превышена длина строки (25 смиволов)']
                ],
                'role' => [
                    ['in', 'range' => User::roleKeys()]
                ],
                'activity' => [
                    'boolean'
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'role' => 'Группа',
            'activity' => 'Активные'
        ];
    }

    public function init() {
        if ($this->activity === null) {
            $this->activity = User::STATE_ACTIVE;
        }
    }

    public function getProvider() {
        $this->validate();

        if ($this->activity === null) {
            $query = User::find();
        } else if ($this->activity) {
            $query = user::find()->where(['activity' => User::STATE_ACTIVE]);
        } else {
            $query = User::find()->where(['activity' => User::STATE_INACTIVE]);
        }

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