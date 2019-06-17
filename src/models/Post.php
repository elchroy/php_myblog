<?php

namespace Src\Models;

use PDO;

class Post
{
	private $connection;
	private $table = 'posts';

	// Post Properties
	public $id;
	public $category_id;
	public $category_name;
	public $title;
	public $body;
	public $author;
	public $created_at;

	public function __construct (PDO $pdoConnection)
	{
		$this->connection = $pdoConnection;
	}

	public function getPosts ()
	{
		// Create query
		$query = "SELECT
					c.name as category_name
					p.id,
					p.category_id,
					p.title,
					p.body,
					p.author,
					p.created_at
				FROM
					{$this->table}
					p

				LEFT JOIN
					categories as c ON p.category_id = c.id
				ORDER BY
					p.created_at DESC
				";
		$query = "SELECT * FROM posts as p ORDER BY p.created_at DESC";

		// Prepared Statement
		$stmt = $this->connection->prepare($query);

		// Execute Statement
		$stmt->execute();

		return $stmt;

		echo $query;
	}


}