<?php

return [
    [
        'path' => '/dashboard',
        'controller' => 'Withdraw',
        'action' => 'dashboard'
    ],
    [
        'path' => '/withdraw',
        'controller' => 'Withdraw',
        'action' => 'withdraw'
    ],

    [
        'path' => '/',
        'controller' => 'Auth',
        'action' => 'loginForm'
    ],
    [
        'path' => '/login',
        'controller' => 'Auth',
        'action' => 'login'
    ],
    [
        'path' => '/logout',
        'controller' => 'Auth',
        'action' => 'logout'
    ],
];