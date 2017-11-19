<?php

namespace app\components;

class User extends \yii\web\User {
    private $_permissions = [];

    public function can($permissionName, $params = [], $allowCaching = true) {
        if ($access = $this->_permissions[$permissionName][$this->role]) {
            if ($access instanceof \Closure) {
                return call_user_func_array($access, $params);
            }

            return $access;
        }

        return false;
    }

    public function __get($name) {
        if ($this->getIdentity() && $this->getIdentity()->canGetProperty($name)) {
            return $this->getIdentity()->$name;
        }

        return parent::__get($name);
    }

    public function getRole() {
        return \app\models\User::ROLE_GUEST;
    }

    public function setPermissions($accessRules) {
        $this->_permissions = [];

        foreach ($accessRules as $permission => $rules) {
            foreach ($rules as $key => $value) {
                if (is_int($key)) {
                    $this->_permissions[$permission][$value] = true;
                } else {
                    $this->_permissions[$permission][$key] = $value;
                }
            }
        }
    }

    public function getPermissions() {
        return $this->_permissions;
    }
}