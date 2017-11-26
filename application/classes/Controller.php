<?php

namespace app\classes;

use yii\web\NotFoundHttpException;

class Controller extends \yii\web\Controller {
    protected static $accessChecker = [
        'class' => 'app\controllers\filters\AccessChecker',
        'modelRequired' => ['toggle', 'view', 'update', 'delete']
    ];

    protected static $menuBuilder = [
        'class' => 'app\controllers\filters\MenuBuilder'
    ];

    protected static $backUrlSetter = [
        'class' => 'app\controllers\filters\BackUrlSetter',
        'only' => ['index']
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

    public $modelClass;
    protected $_model;

    public function getModel() {
        if (!$this->_model) {
            if ($id = $this->request->get('id')) {
                if (!$this->_model = call_user_func_array([$this->modelClass, 'findOne'], [$id])) {
                    throw new NotFoundHttpException('Model not found');
                }
            }
        }

        return $this->_model;
    }
}