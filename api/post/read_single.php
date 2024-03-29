<?php
    header('Access-Control-Allow-Orign:*');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);
    $post->id = isset($_GET["id"]) ? $_GET["id"] : die();
    $result = $post->read_single();

    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => $body,
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name
    );

    echo json_encode($post_item);