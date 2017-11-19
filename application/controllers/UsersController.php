<?php

namespace app\controllers;

use app\models\filters\UsersFilter;
use yii\helpers\Url;

class UsersController extends \app\classes\Controller {
    public function actionIndex() {
        $filter = new UsersFilter();
        $filterActive = false;
        $filterReset = '';


        if ($this->request->get('UsersFilter')) {
            $filter->load($this->request->get());
            $filterActive = true;
            $filterReset = Url::to(['index']);
        }


        return $this->render('list', compact('filter', 'filterActive', 'filterReset'));
    }

    public function actionView($id) {

    }

    public function actionUpdate() {

    }

    public function actionDelete() {

    }
}