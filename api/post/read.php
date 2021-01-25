<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$blog = new Post($db);

// Blog post query
$posts = $blog->read();

// Get row count
$num = $posts->rowCount();

// Check for posts
if($num > 0){
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();
    
    while($row = $posts->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        
        // Push to 'data'
        array_push($posts_arr, $post_item);
        // array_push($posts_arr['data'], $post_item);
        
    }
    
    // Convert to JSON & output
    echo json_encode($posts_arr);
}else{
    // No posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
?>