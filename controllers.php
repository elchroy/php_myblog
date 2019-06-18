<?php

require('vendor/autoload.php');

// use Dotenv\Dotenv as DotEnv;
use Src\Config\Database;
use Src\Models\Post;

$database = new Database();
$connection = $database->connect();

return [
	// methodName => callable
	'getPosts' => function () use ($connection) {
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
			return json_encode($posts_arr, JSON_PRETTY_PRINT);
		} else {
			// No Posts
			json_encode([
				'message' => 'No posts found'
			]);
		}
		// return 'this is a controller action';
	},

	'getPost' => function () {

	},

	'met' => 'HOEGHKEJG'

];