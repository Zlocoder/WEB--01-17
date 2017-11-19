<?php

return [
    'dashboard/index' => ['user', 'support', 'admin'],
    'profile/index' => ['user', 'support', 'admin'],
    'users/index' => ['support', 'admin'],
    'users/create' => ['support', 'admin'],
    'users/view' => ['support', 'admin'],
    'users/update' => ['support', 'admin'],
    'users/update-role' => ['admin'],
    'users/update-activity' => ['admin', 'support' => function($id = null) {
        if ($id) {
            if ($user = \app\models\User::findOne($id)) {
                return $user->role == \app\models\User::ROLE_USER;
            }

            throw new \Exception('User not found');
        }

        return true;
    }],
    'users/delete' => []
];