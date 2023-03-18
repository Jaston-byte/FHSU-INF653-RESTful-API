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

// Check 'category' and 'id' params
if (!$data || !isset($data->category) || !isset($data->id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $category->category = $data->category;
    $category->id = $data->id;
    // Update category
    if ($category->update()) {
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