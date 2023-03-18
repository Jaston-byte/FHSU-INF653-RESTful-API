<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Check if parameters exist
$response = array();

if (!$data || !isset($data->id)) {
    $response['message'] = 'Missing Required Parameters';
} else {
    $quote->id = $data->id;
    // Delete quote
    if ($quote->delete()) {
        $response['id'] = $quote->id;
    } else {
        $response['message'] = 'No Quotes Found';
    }
}

echo json_encode($response);
?>