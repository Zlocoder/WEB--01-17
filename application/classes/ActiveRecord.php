<?php

namespace app\classes;

use yii\base\InvalidConfigException;
use yii\validators\Validator;

class ActiveRecord extends \yii\db\ActiveRecord {
    protected static $tableName = '';

    protected static $timestamp = [
        'class' => 'yii\behaviors\TimestampBehavior',
        'createdAtAttribute' => 'created',
        'updatedAtAttribute' => false
    ];

    protected static $activity = [
        'class' => 'app\models\behaviors\ActivityBehavior'
    ];

    public static function tableName() {
        return static::$tableName;
    }

    public function init() {
        parent::init();

        if (static::$timestamp) {
            $timestamp = array_merge(self::$timestamp, static::$timestamp);

            if (empty($timestamp['value']) && $timestamp['value'] !== false) {
                $timestamp['value'] = new \yii\db\Expression('NOW()');
            }

            $this->attachBehavior('timestamp', $timestamp);
        }

        if (static::$activity) {
            $activity = array_merge(self::$activity, static::$activity);

            $this->attachBehavior('activity', $activity);
        }
    }

    public function createValidators()
    {
        $validators = new \ArrayObject();
        foreach ($this->rules() as $scenario => $fields) {
            if ($scenario == 'safe') {
                $validator = Validator::createValidator('safe', $this, $fields, ['on' => 'safe']);
                $validators->append($validator);
                continue;
            }

            foreach ($fields as $field => $rules) {
                foreach ($rules as $rule) {
                    if ($rule instanceof Validator) {
                        $validators->append($rule);
                    } elseif (is_string($rule)) {
                        $validator = Validator::createValidator($rule, $this, $field, ['on' => $scenario]);
                        $validators->append($validator);
                    } elseif (is_array($rule) && isset($rule[0])) {
                        $validator = Validator::createValidator($rule[0], $this, $field, array_merge(array_slice($rule, 1), ['on' => $scenario]));
                        $validators->append($validator);
                    } else {
                        throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
                    }
                }
            }
        }

        return $validators;
    }
}