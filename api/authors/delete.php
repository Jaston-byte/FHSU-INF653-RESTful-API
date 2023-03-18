<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// get data
$data = json_decode(file_get_contents("php://input"));

// Check if 'id' exists
if (!$data || !isset($data->id)) {
    echo json_encode(
        array('message' => "Missing Required Parameters")
    );
} else {
    $author->id = $data->id;
    // delete author
    if ($author->delete()) {
        echo json_encode(
            array('id' => $author->id)
        );
    } else {
        echo json_encode(
            array('message' => 'author_id not found')
        );
    }
}
?>