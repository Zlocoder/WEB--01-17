<?php

namespace app\classes;

class Url extends \yii\helpers\BaseUrl {
    public static function normalizeRoute($route) {
        return parent::normalizeRoute($route);
    }
}
