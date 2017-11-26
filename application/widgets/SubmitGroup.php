<?php

namespace app\widgets;

use yii\bootstrap\Html;

class SubmitGroup extends \yii\widgets\InputWidget {
    public $defaultButton = false;
    public $defaultText = 'Все';
    public $defaultValue = '';

    public $defaultClass = 'btn-default';
    public $activeClass = 'btn-primary';

    public $model;
    public $attribute;
    public $items;
    public $submitOptions = [];
    public $strictCompare = false;

    public function init() {
        parent::init();

        if (!$this->name) {
            $this->name = Html::getInputName($this->model, $this->attribute);
        }

        if (!$this->value) {
            $this->value = $this->model->{$this->attribute};
        }

        Html::addCssClass($this->submitOptions, 'btn');
    }

    public function run() {
        Html::addCssClass($this->options, 'btn-group');

        echo Html::beginTag('div', $this->options);

        if ($this->defaultButton) {
            $options = array_merge($this->submitOptions, [
                'value' => $this->defaultValue,
                'name' => $this->name
            ]);
            Html::addCssClass($options, $this->value === $this->defaultValue ? $this->activeClass : $this->defaultClass);
            echo Html::submitButton($this->defaultText, $options);
        }

        foreach ($this->items as $value => $text) {
            $options = array_merge($this->submitOptions, [
                'value' => $value,
                'name' => $this->name
            ]);

            Html::addCssClass($options, $this->compare($value, $this->value) ? $this->activeClass : $this->defaultClass);
            echo Html::submitButton($text, $options);
        }

        echo Html::endTag('div');
    }

    protected function compare($value1, $value2) {
        if ($this->strictCompare) {
            return $value1 === $value2;
        }

        return $value1 == $value2;
    }
}