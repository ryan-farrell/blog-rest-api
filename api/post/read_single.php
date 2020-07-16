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

// Get ID
$oPost->iID = isset($_GET['id']) ? $_GET['id'] : die;

// Get Post
$oPost->readSingle();

// Create array
$aPost = [
    'id' => $oPost->iID,
    'title' => $oPost->sTitle,
    'body' => $oPost->sBody,
    'author' => $oPost->sAuthor,
    'category_id' => $oPost->iCategoryID,
    'category_name' => $oPost->sCategoryName,
];

// Make JSON
print_r(json_encode($aPost));