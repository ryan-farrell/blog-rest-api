<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../project/classes/Post.php';

// Instantiate DB & Connect
$oDB = new Database();
$oDBConn = $oDB->connect();

// Instantiate Post object
$oPost = new Post($oDBConn);

// Get raw posted data
$data = json_decode(file_get_contents('php://input'));

// Set ID
$oPost->iID = $data->id;

// Retrieve items from the post data
$oPost->sTitle = $data->title;
$oPost->sBody = $data->body;
$oPost->sAuthor = $data->author;
$oPost->iCategoryID = $data->category_id;

// Create post
if ($oPost->update()) {
    echo json_encode(
        ['message' => 'Post Updated']
    );
} else {
    echo json_encode(
        ['message' => 'Post Not Updated']
    );
}
