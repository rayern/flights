<?php 
return [
    '/users' => [
        'middleware' => ['first', 'auth', 'second'],
        ['get' => 'User/UserController@list'],
        ['post' => 'User/UserController@create'],
        ['put' => 'User/UserController@put']
    ],
];
?>