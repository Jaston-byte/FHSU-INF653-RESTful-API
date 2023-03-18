<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Read Author query
$result = $author->read();
// Get row count
$num = $result->rowCount();

// check if any authors exist
if ($num > 0) {
    // Author array
    $author_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // Push to "data"
        array_push($author_arr, $author_item);
    }
    // output JSON
    echo json_encode($author_arr);
} else {
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
}
?>