<?php

namespace App\Migrations;

defined('ROOTPATH') OR exit('Access Denied!');

class CreatelistingTable
{
    public function up()
    {
        return "CREATE TABLE listings (
    `id` int(11) NOT NULL,
    `author_id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `views` int(11) DEFAULT 0,
    `category` enum('for_sale','for_rent') NOT NULL,
    `lga` varchar(255) NOT NULL,
    `state` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `price` double NOT NULL,
    `sittingroom` int(11) NOT NULL,
    `bedroom` int(11) NOT NULL,
    `bathroom` int(11) NOT NULL,
    `kitchen` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `deleted_at` timestamp NULL DEFAULT NULL
);";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS listings;";
    }
}