<?php

require('vendor/autoload.php');

// use Dotenv\Dotenv as DotEnv;
use Src\Config\Database;
use Src\Models\Post;

// Set Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$database = new Database();
$connection = $database->connect();

$post = new Post($connection);

$postResults = $post->getPosts();

// Get Row Count
$num = $postResults->rowCount();

// Check if there are posts
if ($num > 0) {
	$posts_arr = [];
	$posts_arr['data'] = [];

	while ($row = $postResults->fetch()) {
		extract($row);
		array_push($posts_arr['data'], [
			'id' => $id,
			'category_id' => $category_id,
			// 'category_name' => $category_name,
			'title' => $title,
			'body' => html_entity_decode($body),
			'author' => $author,
			'created_at' => $created_at,
		]);
	}

	// Turn to JSON
	$jsonResponse = json_encode($posts_arr, JSON_PRETTY_PRINT);
	echo $jsonResponse;
} else {
	// No Posts
	echo json_encode([
		'message' => 'No posts found'
	]);
}

// var_dump($connection, 'herer');

