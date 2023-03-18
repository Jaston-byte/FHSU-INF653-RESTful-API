<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// get data
$data = json_decode(file_get_contents("php://input"));

// Check if 'category' exists
if (!$data || !isset($data->id)) {
    echo json_encode(
        array('message' => "Missing Required Parameters")
    );
} else {
    $category->id = $data->id;
    // delete category
    if ($category->delete()) {
        echo json_encode(
            array('id' => $category->id)
        );
    } else {
        echo json_encode(
            array('message' => 'category_id not found')
        );
    }
}
?>