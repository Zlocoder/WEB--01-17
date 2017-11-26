<?php

namespace app\controllers;

use app\models\Tariff;
use yii\data\ActiveDataProvider;

class TariffsController extends \app\classes\Controller {
    public $modelClass = 'app\models\Tariff';

    public function actionIndex() {
        $provider = new ActiveDataProvider([
            'query' => Tariff::find()->where(['companyId' => $this->user->company->id]),
            'pagination' => [
                'pageSizeParam' => false,
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'priceFrom' => SORT_ASC,
                ],
            ]
        ]);

        return $this->render('list', compact('provider'));
    }

    public function actionCreate() {

    }

    public function actionUpdate() {

    }

    public function actionToggle() {

    }

    public function actionDelete() {

    }
}