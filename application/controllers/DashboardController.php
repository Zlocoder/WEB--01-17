<?php

namespace app\controllers;

class DashboardController extends \app\classes\Controller {
    public function actionIndex() {
        return $this->render('/dashboard');
    }
}
