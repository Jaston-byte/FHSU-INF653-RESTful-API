<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Get ID
$category->id = ($_GET['id']);

if (!empty($category->id)) {
    // Get category
    $category->read_single();

    // Create array
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    if (!empty($category_arr) && $category_arr['category'] !== null) {
        // Make JSON
        print_r(json_encode($category_arr));
    } else {
        // No categories
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
} else {
    // No id parameter
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}
?>