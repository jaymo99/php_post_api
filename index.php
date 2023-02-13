<?php

// Set the API endpoint URL
$url = 'http://localhost/php_api/post.php';

// Set the request data
$data = array('f_name' => 'Sam', 'l_name' => 'Simon', 'email' => 'sam.simon@example.com');

// Create a stream context
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json' . "\r\n",
        'content' => json_encode($data)
    )
));

// Send the POST request and get the response
$response = file_get_contents($url, false, $context);

// Decode the response into a PHP array
$response_data = json_decode($response, true);
echo $response_data['message'];