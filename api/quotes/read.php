<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Read Quote query
$result = $quote->read();
// Get row count
$num = $result->rowCount();

// check if any categoriess
if ($num > 0) {
    // Quote array
    $quote_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author_name,
            'category' => $category_name
        );
        array_push($quote_arr, $quote_item);
    }
    // output JSON
    echo json_encode($quote_arr);
} else {
    echo json_encode(
        array('message' => 'quote_id Not Found')
    );
}
?>