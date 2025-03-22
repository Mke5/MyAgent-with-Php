<?php

namespace App\Migrations;

defined('ROOTPATH') OR exit('Access Denied!');

class Createlistings_imageTable
{
    public function up()
    {
        return "CREATE TABLE listings_images (
    listing_id INT NOT NULL,
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE,
    image VARCHAR(255) NOT NULL,
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS listings_images;";
    }
}