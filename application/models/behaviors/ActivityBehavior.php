<?php

namespace app\models\behaviors;

class ActivityBehavior extends \yii\behaviors\AttributeBehavior {
    public $activeState = 1;
    public $inactiveState = 0;
    public $defaultState = 0;
    public $attribute = 'activity';
    public $activeText = 'Активный';
    public $inactiveText = 'Не активный';
    public $preserveNonEmptyValues = true;

    public function init() {
        $this->attributes[\yii\db\ActiveRecord::EVENT_BEFORE_INSERT] = $this->attribute;
        $this->value = $this->defaultState;
    }

    public function setDefaultState($state) {
        $this->value = $state;
    }

    public function getDefaultState() {
        return $this->value;
    }

    public function toggle() {
        $this->owner->{$this->attribute} = $this->owner->{$this->attribute} ? $this->inactiveState : $this->activeState;

        return $this->owner;
    }

    public function activate() {
        $this->owner->{$this->attribute} = $this->activeState;

        return $this->owner;
    }

    public function deactivate() {
        $this->owner->{$this->attribute} = $this->innactiveState;

        return $this->owner;
    }

    public function getActivityText() {
        if ($this->owner->{$this->attribute} == $this->activeState) {
            return $this->activeText;
        }

        if ($this->owner->{$this->attribute} == $this->inactiveState) {
            return $this->inactiveText;
        }

        return null;
    }
}