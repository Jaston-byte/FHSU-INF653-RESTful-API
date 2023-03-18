<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get ID
$author->id = ($_GET['id']);

if (!empty($author->id)) {
    // Get author
    $author->read_single();

    // Create array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    if (!empty($author_arr) && $author_arr['author'] !== null) {
        // Make JSON
        print_r(json_encode($author_arr));
    } else {
        // No categories
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
} else {
    // No id parameter
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
}
?>