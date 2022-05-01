<?php 
return [
    '/search' => [
        'middleware' => 'jwt',
        'POST' => 'FlightController@search',
    ],
];
?>