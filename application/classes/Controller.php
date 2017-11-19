<?php

namespace app\classes;

class Controller extends \yii\web\Controller {
    protected static $accessChecker = [
        'class' => 'app\controllers\filters\AccessChecker'
    ];

    protected static $menuBuilder = [
        'class' => 'app\controllers\filters\MenuBuilder'
    ];

    protected static $backUrlSetter = [
        'class' => 'app\controllers\filters\BackUrlSetter'
    ];

    public function init() {
        if (static::$accessChecker) {
            $behavior = array_merge(self::$accessChecker, static::$accessChecker);

            $this->attachBehavior('accessChecker', $behavior);
        }

        if (static::$menuBuilder) {
            $behavior = array_merge(self::$menuBuilder, static::$menuBuilder);

            $this->attachBehavior('menuBuilder', $behavior);
        }

        if (static::$backUrlSetter) {
            $behavior = array_merge(self::$backUrlSetter, static::$backUrlSetter);

            $this->attachBehavior('backUrlSetter', $behavior);
        }
    }

    public function __get($name) {
        if (\Yii::$app->canGetProperty($name)) {
            return \Yii::$app->$name;
        }

        return parent::__get($name);
    }
}