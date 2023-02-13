<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "sample_db");

//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Extract the data into variables
    $f_name = $data['f_name'];
    $l_name = $data['l_name'];
    $email = $data['email'];

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error in query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Email already exists, return error
        echo json_encode(array("message" => "'$email' - already exists"));
        exit;
    }

    // Insert the data into the database
    $query = "INSERT INTO users (f_name, l_name, email) VALUES ('$f_name', '$l_name', '$email')";
    $result = mysqli_query($conn, $query);
    
    // Check if the insertion was successful
    if ($result) {
        $response = array("message" => "'$email' - created successfully");
    } else {
        $response = array("message" => "error while creating - '$email'");
    }
    
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}