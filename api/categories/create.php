<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Check 'category' parameter exists
if (!$data || !isset($data->category)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $category->category = $data->category;
    // Create category
    if ($category->create()) {
        echo json_encode(
            array(
                'id' => $category->id,
                'category' => $category->category
            )
        );
    } else {
        echo json_encode(
            array('message' => 'category_id not found')
        );
    }
}
?>