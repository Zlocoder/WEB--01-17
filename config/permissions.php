<?php

return [
    'dashboard/index' => ['admin', 'client'],

    'profile/index' => ['admin', 'client'],

    'users/index' => ['admin'],
    'users/create' => ['admin'],
    'users/view' => ['admin'],
    'users/update' => ['admin'],
    'users/toggle' => ['admin'],
    'users/delete' => [],

    'companies/index' => ['admin'],

    'tariffs/index' => ['client'],
    'tariffs/create' => ['client'],
    'tariffs/update' => ['client'],
    'tariffs/toggle' => ['client'],
    'tariffs/delete' => ['client'],
];