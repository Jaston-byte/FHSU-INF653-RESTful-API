<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get ID
$quote->id = ($_GET['id']);

if (!empty($quote->id)) {
    // Get quote
    $quote->read_single();

    if (!empty($quote->quote)) {
        // Create array
        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author_id,
            'category' => $quote->category_id
        );

        // Make JSON
        echo json_encode($quote_arr);
    } else {
        // No quote found
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
} else {
    // No id parameter
    echo json_encode(
        array('message' => 'quote_id Not Found')
    );
}

?>