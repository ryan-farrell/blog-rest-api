<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../project/classes/Post.php';

// Instantiate DB & Connect
$oDB = new Database();
$oDBConn = $oDB->connect();

// Instantiate Post object
$oPost = new Post($oDBConn);

// Blog Post Query
$aResult = $oPost->read();

//Get row count
$iNum = $aResult->rowCount();

// Check if any posts
if ($iNum) {
    // Post array
    $aPosts = [];
    $aPosts['data'] = [];

    
    while ($row = $aResult->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $aPostItem = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        ];

    // Push 
    array_push($aPosts['data'], $aPostItem);
    }

    // Turn to JSON
    echo json_encode($aPosts);

} else {
    // No posts
    echo json_encode(['message' => 'No posts found']);

}