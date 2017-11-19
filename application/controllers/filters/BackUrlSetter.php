<?php

namespace app\controllers\filters;

class BackUrlSetter extends \yii\base\ActionFilter {
    public function afterAction($action, $result) {
        \Yii::$app->user->setReturnUrl(\Yii::$app->request->absoluteUrl);

        return $result;
    }
}