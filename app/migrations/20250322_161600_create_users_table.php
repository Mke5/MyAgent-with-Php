<?php

namespace App\Migrations;

defined('ROOTPATH') OR exit('Access Denied!');

class CreateuserTable
{
    public function up()
    {
        return "CREATE TABLE users (
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    INDEX (email),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    terms TINYINT(1) DEFAULT 0,
    image VARCHAR(255) NOT NULL,
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS users;";
    }
}