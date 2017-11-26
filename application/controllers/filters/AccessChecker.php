<?php

namespace app\controllers\filters;

use yii\web\ForbiddenHttpException;

class AccessChecker extends \yii\base\ActionFilter {
    public $modelRequired = [];

    public function beforeAction($action) {
        if (in_array($action->id, $this->modelRequired)) {
            $result = \Yii::$app->user->can(\Yii::$app->requestedRoute ?: \Yii::$app->defaultRoute, [$this->owner->model->id]);
        } else {
            $result = \Yii::$app->user->can(\Yii::$app->requestedRoute ?: \Yii::$app->defaultRoute);
        }

        if ($result) {
            return true;
        }

        if (\Yii::$app->user->isGuest) {
            \Yii::$app->user->loginRequired();
        } else {
            throw new ForbiddenHttpException('Недостаточно прав для совершения данного действия.');
        }
    }
}