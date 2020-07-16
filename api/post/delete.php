<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Create post
if ($oPost->delete()) {
    echo json_encode(
        ['message' => 'Post Deleted']
    );
} else {
    echo json_encode(
        ['message' => 'Post Not Deleted']
    );
}