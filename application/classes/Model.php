<?php

namespace app\classes;

use yii\base\InvalidConfigException;
use yii\validators\Validator;

class Model extends \yii\base\Model {
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