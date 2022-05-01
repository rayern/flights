<?php 
return [
    '/search' => [
        'middleware' => 'Authorization',
        'POST' => 'FlightController@search',
    ]
];
?>