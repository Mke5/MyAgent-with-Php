<?php

namespace App\Migrations;

defined('ROOTPATH') OR exit('Access Denied!');

class CreateuserTable
{
    public function up()
    {
        return "CREATE TABLE users (
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    INDEX (email),
    password VARCHAR(255) NOT NULL,
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