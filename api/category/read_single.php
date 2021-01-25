<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Category query
$category->read_single();

$result = array(
    'id' => $category->id,
    'name' => $category->name,
    'time_created' => $category->created_at

);

echo json_encode($result);

?>