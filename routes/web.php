<?php 
return [
    '/login' => [
        'POST' => 'UserController@login',
    ],
    '/register' => [
        'POST' => 'UserController@register',
    ],
    '' => [
        'GET' => 'HomeController@home'
    ]
];
?>