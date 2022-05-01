<?php 
return [
    '/login' => [
        'POST' => 'LoginController@login',
    ],
    '/search' => [
        'middleware' => 'Authorization',
        'POST' => 'FlightController@search',
    ],
];
?>