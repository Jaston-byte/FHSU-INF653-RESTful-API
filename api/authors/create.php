<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if 'author' parameter exists
if (!$data || !isset($data->author)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $author->author = $data->author;
    // Create author
    if ($author->create()) {
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    } else {
        echo json_encode(
            array('message' => 'author_id not found')
        );
    }
}
?>