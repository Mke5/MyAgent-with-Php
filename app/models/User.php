<?php

namespace App\Models;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class User
{
	use Model;
	use Database;

	protected $table = 'users';
	protected $allowedColumns = ['email', 'password'];

	public function validate($data)
	{
		if(isset($data['email']) && empty($data['email'])) {
			throw new \Exception("Email is required");
		} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			throw new \Exception("Invalid email format");
		}
		
		if(isset($data['password']) && empty($data['password'])) {
			throw new \Exception("Password is required");
		}
		
		if(isset($data['terms']) && empty($data['terms'])) {
			throw new \Exception("You must agree to the terms and conditions");
		}

		if(isset($data['password']) && strlen($data['password']) < 6) {
			throw new \Exception("Password must be at least 6 characters long");
		}

		if(isset($data['fname']) && empty($data['fname'])) {
			throw new \Exception("First name is required");
		}

		if(isset($data['lname']) && empty($data['lname'])) {
			throw new \Exception("Last name is required");
		}

		if(isset($data['image']) && $data['image']['error'] !== 4) {
			$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
			if (!in_array($data['image']['type'], $allowedTypes)) {
				throw new \Exception('Invalid image type. Allowed: JPEG, PNG, GIF.');
			}
		}

		return true;
	}

	public function findById($id)
	{
		$sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
		$result = $this->read($sql, ['id' => $id]);

		return $result ? $result[0] : false;
	}

	public function findByEmail($email)
	{
		$sql = "SELECT * FROM $this->table WHERE email = :email LIMIT 1";
		$result = $this->read($sql, ['email' => $email]);

		return $result ? $result[0] : false;
	}

	public function getAll(){
		$sql = "SELECT u.*, COUNT(l.id) AS total_listings 
				FROM $this->table AS u
				LEFT JOIN listings AS l ON u.id = l.author_id
				WHERE u.role != 'admin'
				GROUP BY u.id";
		$result = $this->read($sql);

		return $result ? $result : false;
	}

	public function getUserImage($userId)
	{
		$sql = "SELECT image FROM $this->table WHERE id = :id LIMIT 1";
		$result = $this->read($sql, ['id' => $userId]);

		return $result ? $result[0]->image : false;
	}

	public function create($data, $image)
	{
		// Sanitize user input
		$fname = trim($data['fname']);
		$lname = trim($data['lname']);
		$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? $data['email'] : null;
		$password = $data['password'];

		if (!$email) {
			throw new \Exception('Invalid email format.');
		}

		// Check if user exists
		if ($this->findByEmail($email)) {
			throw new \Exception('Email already exists!');
		}

		// Hash password
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		// Upload image
		$imageName = null;
		if ($image['error'] === 0) {

			try {
				$imageName = $this->uploadImage($image);
			} catch (\Throwable $th) {
				throw new \Exception($th->getMessage());
			}
		}

		// Insert into database
		$sql = "INSERT INTO $this->table (fname, lname, email, password, image, role, status) 
				VALUES (:fname, :lname, :email, :password, :image, 'user', 'active')";
		$data = [
			':fname' => $fname,
			':lname' => $lname,
			':email' => $email,
			':password' => $hashedPassword,
			':image' => $imageName
		];

		return $this->write($sql, $data);
	}

	public function login($email, $password)
	{
		$user = $this->findByEmail($email);

		if ($user && isset($user->password) && password_verify($password, $user->password)) {
			return $user;
		}

		throw new \Exception('Invalid email or password.');
	}

	private function uploadImage($image)
	{
		if ($image['error'] !== UPLOAD_ERR_OK) {
			throw new \Exception('File upload error. Code: ' . $image['error']);
		}

		$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/MyAgent/public/assets/profile-pictures/";
		if(!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}
		$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
		$maxFileSize = 1 * 1024 * 1024; // 1MB

		if (!in_array($image['type'], $allowedTypes)) {
			throw new \Exception('Invalid image type. Allowed: JPEG, PNG, GIF.');
		}

		if (!is_uploaded_file($image['tmp_name'])) {
			throw new \Exception('The file was not uploaded via HTTP POST.');
		}

		if ($image['size'] > $maxFileSize) {
			throw new \Exception('Image size exceeds 1MB.');
		}

		// Generate unique file name
		$fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
		$imageName = uniqid('user_', true) . '.' . $fileExtension;
		$imagePath = $uploadDir . $imageName;

		if (move_uploaded_file($image['tmp_name'], $imagePath)) {
			return $imageName;
		}

		if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
			echo "Debugging: Upload failed. Error: " . error_get_last()['message'] . "\n";
			die;
			throw new \Exception('Failed to upload image.');
		}
		
		throw new \Exception('Failed to upload image.');
	}
}
