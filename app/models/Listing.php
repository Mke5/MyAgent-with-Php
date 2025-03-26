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

        if(isset($data['type']) && empty($data['type']))
        {
            throw new \Exception("Type is required");
        }
        
        if(isset($data['description']) && empty($data['description']))
        {
            throw new \Exception("Description is required");
        }

        if(isset($data['sittingroom']) && empty($data['sittingroom']))
        {
            throw new \Exception("Sitting room is required");
        }

        if(isset($data['bathroom']) && empty($data['bathroom']))
        {
            throw new \Exception("Bathroom is required");
        }

        if(isset($data['bedroom']) && empty($data['bedroom']))
        {
            throw new \Exception("Bedroom is required");
        }

        if(isset($data['kitchen']) && empty($data['kitchen']))
        {
            throw new \Exception("Kitchen is required");
        }
        
        if(isset($data['price']) && empty($data['price']))
        {
            throw new \Exception("Price is required");
        }
        
        if(isset($data['category']) && empty($data['category']))
        {
            throw new \Exception("Category is required");
        }
        
        if(isset($data['user_id']) && empty($data['user_id']))
        {
            throw new \Exception("User is required");
        }

        if(isset($data['address']) && empty($data['address']))
        {
            throw new \Exception("Address is required");
        }

        if(isset($data['state']) && empty($data['state']))
        {
            throw new \Exception("State is required");
        }

        if(isset($data['lga']) && empty($data['lga']))
        {
            throw new \Exception("LGA is required");
        }

        if (isset($data['image']) && is_array($data['image']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 1 * 1024 * 1024; // 1MB in bytes
        
            // Check if the number of uploaded images exceeds 10
            if (count($data['image']['name']) > 10) {
                throw new \Exception('You can upload a maximum of 10 images.');
            }
        
            foreach ($data['image']['name'] as $key => $name) {
                if ($data['image']['error'][$key] !== 4) { // Ignore empty file inputs
                    if (!in_array($data['image']['type'][$key], $allowedTypes)) {
                        throw new \Exception('Invalid image type for file: ' . $name . '. Allowed: JPEG, PNG, GIF.');
                    }
        
                    if ($data['image']['size'][$key] > $maxSize) {
                        throw new \Exception('File ' . $name . ' exceeds the 1MB size limit.');
                    }
                }
            }
        }

        return true;
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