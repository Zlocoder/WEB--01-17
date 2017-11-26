<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/views/assets';

    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'app\assets\Adminlte'
    ];
}
