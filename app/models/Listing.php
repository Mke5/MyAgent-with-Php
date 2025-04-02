<?php

namespace App\Models;

defined('ROOTPATH') OR exit('Access Denied!');


class Listing {

    use Model;
    use Database;

    protected $table = 'listings';
    protected $ownerTable = 'users';
    protected $tableImages = 'listings_images';

    public function validate($data)
    {

        if(!isset($data['type']) && empty($data['type']))
        {
            throw new \Exception("Type is required");
        }
        
        if(!isset($data['description']) && empty($data['description']))
        {
            throw new \Exception("Description is required");
        }

        if(!isset($data['sittingroom']) && empty($data['sittingroom']))
        {
            throw new \Exception("Sitting room is required");
        }

        if(!isset($data['bathroom']) && empty($data['bathroom']))
        {
            throw new \Exception("Bathroom is required");
        }

        if(!isset($data['bedroom']) && empty($data['bedroom']))
        {
            throw new \Exception("Bedroom is required");
        }

        if(!isset($data['kitchen']) && empty($data['kitchen']))
        {
            throw new \Exception("Kitchen is required");
        }
        
        if(!isset($data['price']) && empty($data['price']))
        {
            throw new \Exception("Price is required");
        }
        
        if(!isset($data['category']) && empty($data['category']))
        {
            throw new \Exception("Category is required");
        }
        
        if(!isset($data['user_id']) && empty($data['user_id']))
        {
            throw new \Exception("User is required");
        }

        if(!isset($data['address']) && empty($data['address']))
        {
            throw new \Exception("Address is required");
        }

        if(!isset($data['state']) && empty($data['state']))
        {
            throw new \Exception("State is required");
        }

        if(!isset($data['lga']) && empty($data['lga']))
        {
            throw new \Exception("LGA is required");
        }

        if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 1 * 1024 * 1024; // 1MB
            $maxFiles = 10;
        
            $filteredFiles = array_filter($_FILES['image']['name']);
        
            if (empty($filteredFiles)) {
                throw new \Exception('Please upload at least one image.');
            }
        
            if (count($filteredFiles) > $maxFiles) {
                throw new \Exception('You can upload a maximum of 10 images.');
            }
        
            foreach ($_FILES['image']['name'] as $key => $name) {
                if ($_FILES['image']['error'][$key] === UPLOAD_ERR_NO_FILE) {
                    continue; // Ignore empty file fields
                }
        
                if ($_FILES['image']['error'][$key] !== UPLOAD_ERR_OK) {
                    throw new \Exception('Error uploading file: ' . $name);
                }
        
                // Validate MIME type using finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES['image']['tmp_name'][$key]);
                finfo_close($finfo);
        
                if (!in_array($mimeType, $allowedTypes)) {
                    throw new \Exception('Invalid image type for file: ' . $name . '. Allowed: JPEG, PNG, GIF.');
                }
        
                // Check file size
                if ($_FILES['image']['size'][$key] > $maxSize) {
                    throw new \Exception('File ' . $name . ' exceeds the 1MB size limit.');
                }
            }
        } else {
            throw new \Exception('Please upload at least one image.');
        }
        
        

        return true;
    }

    private function createListing($db, $data)
    {
        $link = substr(md5(microtime()), 0, 6);
        $sql = "INSERT INTO $this->table (name, description, sittingroom, bathroom, bedroom, kitchen, price, category, author_id, address, state, lga, link) 
                VALUES (:type, :description, :sittingroom, :bathroom, :bedroom, :kitchen, :price, :category, :user_id, :address, :state, :lga, $link)";
        
        $stmt = $db->prepare($sql);
        if ($stmt->execute($data)) {
            return $db->lastInsertId();
        }

        return false;
    }




    private function deleteUploadedImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    private function createListingImages($db, $listingId, $imagePaths)
    {
        $sql = "INSERT INTO $this->tableImages (listing_id, image) VALUES (:listing_id, :image_path)";
        $stmt = $db->prepare($sql);

        foreach ($imagePaths as $imagePath) {
            $data = [
                'listing_id' => $listingId,
                'image_path' => $imagePath
            ];
            $stmt->execute($data);
        }
    }



    private function uploadImage($image)
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/MyAgent/public/assets/listing-images/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 1 * 1024 * 1024;

        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Upload error ({$image['name']}): Code " . $image['error']);
        }

        if (!in_array($image['type'], $allowedTypes)) {
            throw new \Exception('Invalid image type. Allowed: JPEG, PNG, GIF.');
        }

        if (!is_uploaded_file($image['tmp_name'])) {
            throw new \Exception('The file was not uploaded via HTTP POST.');
        }

        if (!file_exists($image['tmp_name'])) {
            throw new \Exception("Temporary file not found for " . $image['name']);
        }

        if ($image['size'] > $maxFileSize) {
            throw new \Exception('Image size exceeds 1MB.');
        }

        $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('listing_', true) . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;
        $imagePath = $uploadDir . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            throw new \Exception('Failed to upload image: ' . $image['name']);
        }

        return $imageName;
    }   

    public function create($data, $images)
    {
        $uploadedImages = [];
        $db = $this->connect();

        try {
            $db->beginTransaction(); 
                if (!isset($images['name']) || count($images['name']) === 0) {
                throw new \Exception('No images uploaded.');
            }

            foreach ($images['name'] as $key => $name) {
                $image = [
                    'name'     => $images['name'][$key],
                    'type'     => $images['type'][$key],
                    'tmp_name' => $images['tmp_name'][$key],
                    'error'    => $images['error'][$key],
                    'size'     => $images['size'][$key]
                ];
                if ($image['error'] !== UPLOAD_ERR_OK) {
                    throw new \Exception("File upload error for $name. Code: " . $image['error']);
                }
                $uploadedImages[] = $this->uploadImage($image);
            }

            if (!$listingId = $this->createListing($db, $data)) {
                throw new \Exception('Failed to create listing.');
            }

            $this->createListingImages($db, $listingId, $uploadedImages);

            $db->commit();

        } catch (\Exception $e) {
            $db->rollBack();
            $this->deleteUploadedImages($uploadedImages);
            throw $e;
        }
    }



    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result[0] : [];
    }

    public function findByLink($id)
    {
        $sql = "SELECT * FROM $this->table WHERE link = :id LIMIT 1";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result[0] : [];
    }
    
    public function findByUserId($id)
    {
        $sql = "SELECT * FROM $this->table WHERE author_id = :id";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result : [];
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM $this->ownerTable WHERE id = :id";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result[0] : [];
    }
    
    public function findByCategoryId($id)
    {
        $sql = "SELECT * FROM $this->table WHERE category = :id";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result : [];
    }
    
    public function findByCategoryAndUserId($category_id, $user_id)
    {
        $sql = "SELECT * FROM $this->table WHERE category = :category_id AND author_id = :user_id";
        $result = $this->read($sql, ['category_id' => $category_id, 'user_id' => $user_id]);

        return $result ? $result : [];
    }

    public function getRandomListing()
    {
        $sql = "SELECT * FROM $this->table ORDER BY RAND() LIMIT 1";
        $result = $this->read($sql);

        return $result ? $result : [];
    }

    public function getImage($listingId)
    {
        $sql = "SELECT * FROM $this->tableImages WHERE listing_id = :listing_id ORDER BY id ASC LIMIT 1";
        $result = $this->read($sql, ['listing_id' => $listingId]);

        return $result ? $result[0] : [];
    }

    public function getImages($listingId)
    {
        $sql = "SELECT * FROM $this->tableImages WHERE listing_id = :listing_id";
        $result = $this->read($sql, ['listing_id' => $listingId]);

        return $result ? $result : [];
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $result = $this->read($sql);

        return $result ? $result : [];
    }

    public function searchListing($search = null, $address = null, $status = null)
    {
        $sql = "SELECT * FROM $this->table WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (name LIKE :search OR description LIKE :search)";
            $params['search'] = "%$search%";
        }

        if (!empty($address)) {
            $sql .= " AND state = :address";
            $params['address'] = $address;
        }

        if (!empty($status)) {
            $sql .= " AND category = :status";
            $params['status'] = $status;
        }

        return $this->read($sql, $params) ?: [];
    }

    public function timeAgo($time)
    {
        $time = strtotime($time);
        $currentTime = time();
        $timeDifference = $currentTime - $time;
        $seconds = $timeDifference;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2629440);
        $years = round($seconds / 31553280);

        if ($seconds <= 60) {
            return "Just Now";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 hour ago";
            } else {
                return "$hours hours ago";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "1 day ago";
            } else {
                return "$days days ago";
            }
        } else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "1 week ago";
            } else {
                return "$weeks weeks ago";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 month ago";
            } else {
                return "$months months ago";
            }
        } else {
            if ($years == 1) {
                return "1 year ago";
            } else {
                return "$years years ago";
            }
        }
    }

}