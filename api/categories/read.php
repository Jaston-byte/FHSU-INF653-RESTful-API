<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Read Category query
$result = $category->read();
// Get row count
$num = $result->rowCount();

// check if any categories exist
if ($num > 0) {
    // Category array
    $category_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        // Push to "data"
        array_push($category_arr, $category_item);
    }
    // output JSON
    echo json_encode($category_arr);
} else {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}
?>