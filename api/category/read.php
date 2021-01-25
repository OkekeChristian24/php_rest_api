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

// Category query
$categories = $category->read_all();

// Get number of rows
$num = $categories->rowCount();

if($num > 0){
    $category_arr = array();
    
    while($row = $categories->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $each_arr = array(
            'id' => $id,
            'name' => $name,
            'time_created' => $created_at
        );
        
        array_push($category_arr, $each_arr);
    }
    
    echo json_encode($category_arr);
}else{
    echo json_encode(array('message' => 'No Categories Found'));
}

?>