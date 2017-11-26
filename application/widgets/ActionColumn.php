<?php

namespace app\widgets;

use app\classes\Url;
use rmrevin\yii\fontawesome\component\Icon;
use yii\bootstrap\Html;

class ActionColumn extends \yii\grid\ActionColumn {
    public $template = '{toggle} {view} {update} {delete}';

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['toggle'])) {
            $this->buttons['toggle'] = function($url, $model, $key) {
                return Html::a(new Icon($model->activity ? 'check-square-o' : 'square-o'), $url, array_merge([
                    'title' => $model->activity ? 'Выключить' : 'Включить',
                    'aria-label' => $model->activity ? 'Выключить' : 'Включить',
                    'data-pjax' => '0',
                ], $this->buttonOptions));
            };
        }

        $this->initDefaultButton('view', 'eye-open');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', ['data-confirm' => 'Вы уверены?']);


        parent::initDefaultButtons();
    }


    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name]) &&
                \Yii::$app->user->can($this->controller ? $this->controller . '/' . $name : Url::normalizeRoute($name), ['id' => $key])) {

                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }

            return '';
        }, $this->template);
    }


}