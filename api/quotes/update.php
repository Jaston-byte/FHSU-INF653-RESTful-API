<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    exit();
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->update()) {
    echo json_encode(
        array('id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id)
    );
} else if (empty($quote->quote)) {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}
?>