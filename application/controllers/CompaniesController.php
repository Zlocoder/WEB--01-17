<?php

namespace app\controllers;

use app\models\Company;
use yii\data\ActiveDataProvider;

class CompaniesController extends \app\classes\Controller {
    public $modelClass = 'app\models\Company';

    public function actionIndex() {
        $provider = new ActiveDataProvider([
            'query' => Company::find()->joinWith('user'),
            'pagination' => [
                'pageSizeParam' => false,
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'created' => SORT_DESC
                ],
                'attributes' => [
                    'userId' => [
                        'asc' => ['users.login' => SORT_ASC],
                        'desc' => ['users.login' => SORT_DESC],
                    ],
                    'name',
                    'created'
                ]
            ]
        ]);

        return $this->render('list', compact('provider'));
    }
}