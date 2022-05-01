<?php 
return [
    '/search' => [
        'middleware' => 'jwt',
        'post' => 'FlightController@search',
        
    ],
];
?>