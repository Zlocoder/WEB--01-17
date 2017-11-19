<?php

namespace app\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\component\Icon;

class Box extends \yiister\adminlte\widgets\Box {
    public $footer;

    public function init()
    {
        Widget::init();
        $this->initTools();
        Html::addCssClass($this->options, 'box box-' . $this->type);
        if ($this->filled) {
            Html::addCssClass($this->options, 'box-solid');
        }
        echo Html::beginTag('div', $this->options);

        if (isset($this->header)) {
            echo Html::beginTag('div', ['class' => 'box-header with-border']);
            echo Html::tag(
                'h3',
                (isset($this->icon) ? new Icon($this->icon) . '&nbsp;' : '') . $this->header,
                ['class' => 'box-title']
            );
            if (!empty($this->tools)) {
                echo Html::tag('div', $this->tools, ['class' => 'box-tools pull-right']);
            }
            echo Html::endTag('div');
        }

        echo Html::beginTag('div', ['class' => 'box-body']);
    }

    public function run()
    {
        echo Html::endTag('div');

        if (isset($this->footer)) {
            echo Html::tag('div', $this->footer, ['class' => 'box-footer with-border']);
        }

        echo Html::endTag('div');
        Widget::run();
    }
}