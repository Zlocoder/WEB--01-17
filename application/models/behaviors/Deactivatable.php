<?php

namespace app\models\behaviors;

class Activatable extends \yii\behaviors\AttributeBehavior {
    public $defaultState = 0;
    public $activeState = 1;
    public $innactiveState = 0;
    public $attribute = 'active';

    public function init() {
        $this->attributes[\yii\db\ActiveRecord::EVENT_BEFORE_INSERT] = $this->attribute;
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

}