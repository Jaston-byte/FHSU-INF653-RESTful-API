<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate a new Database object and connect to the database
$database = new Database();
$db = $database->connect();

// Instantiate a new Quote object
$quote = new Quote($db);

// Get the raw posted data and decode it from JSON
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set the properties of the Quote object
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Try to create a new quote
try {
    if ($quote->create()) {
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            )
        );
    }
} catch (PDOException $e) {
    if ($e->getCode() == '23503') {
        $key_value = substr($e->getMessage(), strpos($e->getMessage(), '(') + 1, strpos($e->getMessage(), ')') - strpos($e->getMessage(), '(') - 1);
        if ($key_value === 'author_id') {
            echo json_encode(array('message' => 'author_id Not Found'));
        } else {
            echo json_encode(array('message' => 'category_id Not Found'));
        }
    }
}