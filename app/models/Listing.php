<?php

namespace App\Models;

defined('ROOTPATH') OR exit('Access Denied!');


class Listing {

    use Model;
    use Database;

    protected $table = 'listings';
    protected $tableImages = 'listing_images';

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

    private function createListing($data)
    {
        $sql = "INSERT INTO $this->table (type, description, sittingroom, bathroom, bedroom, kitchen, price, category, author_id, address, state, lga) VALUES (:type, :description, :sittingroom, :bathroom, :bedroom, :kitchen, :price, :category, :user_id, :address, :state, :lga)";

        return $this->write($sql, $data, $returnID = true);
    }

    private function createListingImages($listingId, $images)
    {
        $sql = "INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)";
        foreach ($images as $image) {
            $data = [
                'listing_id' => $listingId,
                'image_path' => $image
            ];
    
            $this->write($sql, $data);
        }
    }

    public function create($data, $images)
    {
        if (!$listingId = $this->createListing($data)) {
            throw new \Exception('Failed to create listing.');
        }

        $this->createListingImages($listingId, $images);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result : [];
    }
    
    public function findByUserId($id)
    {
        $sql = "SELECT * FROM $this->table WHERE user_id = :id";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result : [];
    }
    
    public function findByCategoryId($id)
    {
        $sql = "SELECT * FROM $this->table WHERE category_id = :id";
        $result = $this->read($sql, ['id' => $id]);

        return $result ? $result : [];
    }
    
    public function findByCategoryAndUserId($category_id, $user_id)
    {
        $sql = "SELECT * FROM $this->table WHERE category_id = :category_id AND user_id = :user_id";
        $result = $this->read($sql, ['category_id' => $category_id, 'user_id' => $user_id]);

        return $result ? $result : [];
    }

    public function getRandomListing()
    {
        $sql = "SELECT * FROM $this->table ORDER BY RAND() LIMIT 1";
        $result = $this->read($sql);

        return $result ? $result : [];
    }

    public function getOneListingImage($listingId)
    {
        $sql = "SELECT * FROM $this->tableImages WHERE listing_id = :listing_id ORDER BY id ASC LIMIT 1";
        $result = $this->read($sql, ['listing_id' => $listingId]);

        return $result ? $result : [];
    }

    public function getListingImages($listingId)
    {
        $sql = "SELECT * FROM $this->tableImages WHERE listing_id = :listing_id";
        $result = $this->read($sql, ['listing_id' => $listingId]);

        return $result ? $result : [];
    }

    public function getAllListings()
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
            $sql .= " AND address = :address";
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