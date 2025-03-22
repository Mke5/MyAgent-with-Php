<?php

namespace App\Migrations;

defined('ROOTPATH') OR exit('Access Denied!');

class CreatelistingTable
{
    public function up()
    {
        return "CREATE TABLE listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    views INT NOT NULL,
    category ENUM('for_sale', 'for_rent') NOT NULL,
    country VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    price DOUBLE NOT NULL,
    date_created DATETIME NOT NULL,
    type ENUM('house', 'land') NOT NULL,
    sittingroom INT NOT NULL,
    bedroom INT NOT NULL,
    bathroom INT NOT NULL,
    kitchen INT NOT NULL,
    furnished TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS listings;";
    }
}