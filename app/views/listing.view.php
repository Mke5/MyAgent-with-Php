<?php

    require_once "../app/core/init.php";

    use app\models\User;
    use app\models\Listing;

    $listings = new Listing();
    $user = new User();

    $category = (isset($_GET['category'])) ? filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
    $type = (isset($_GET['type'])) ? filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";

    $allListings = $listings->getAllListings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listings</title>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/listing.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/index.css">

    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

        /* Form Container */
        .filter-form {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 20px 15px;
            gap: 10px;
            font-family: sans-serif;
            width: 100%;
        }

        /* Input Group: Flag + Text Input (50% width) */
        .input-group {
            display: flex;
            align-items: center;
            flex: 3; /* Takes up 50% of the form width */
            max-width: 100%;
        }

        .flag-icon {
            width: 24px;
            height: auto;
            margin-right: 6px;
        }

        .input-group input[type="text"] {
            flex: 1; /* Allows input to take up remaining space in its container */
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            font-size: 14px;
            outline: none;
        }

        /* Select Boxes */
        .filter-select {
            flex: 1; /* Distributes remaining 50% among all selects */
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            font-size: 14px;
            outline: none;
            cursor: pointer;
        }

        /* Search Button */
        .search-btn {
            background-color: #000;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;

        }

        .search-btn:hover {
            transform: translateY(-3px);
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 768px) {
            .filter-form {
                flex-wrap: wrap;
            }

            .input-group {
                max-width: 100%; /* Full width on smaller screens */
                flex: none;
                width: 100%;
            }

            .filter-select,
            .search-btn {
                flex: none;
                width: 100%;
            }
        }






        .btnL{
            margin-top: 1rem;
            display: inline-block;
            padding:.8rem 3.5rem;
            border-radius: .5rem;
            font-size: 14px;
            color: #fff;
            background: #000;
            cursor: pointer;
            text-align: center;
            border: none;
        }

        .btnL:hover{
            transform: translateY(-3px);
        }
        
        section{
            padding:2rem 4%;
        }.featured .box-container{
            display: flex;
            flex-wrap: wrap;
            gap:1.5rem;
        }

        .featured .box-container .box{
            border:.1rem solid rgba(0,0,0,.2);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            border-radius: .5rem;
            overflow:hidden;
            background:#fff;
            flex:1 1 1 1;
        }

        .featured .box-container .box .image-container{
            overflow:hidden;
            position: relative;
            width: 100%;
            height: 15rem;
        }

        .featured .box-container .box .image-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .2s linear;
        }

        .featured .box-container .box:hover .image-container img{
            transform: scale(1.1);
        }

        .featured .box-container .box .image-container .info{
            position: absolute;
            top:1rem; left:0;
            display: flex;
        }

        .featured .box-container .box .image-container .info h3{
            font-weight: 500;
            font-size: 12px;
            color:#fff;
            background:rgba(0,0,0,.3);
            border-radius: .5rem;
            padding:.5rem 1.5rem;
            margin-left: 1rem;
        }

        .featured .box-container .box .content{
            padding:1.5rem;
        }

        .featured .box-container .box .content .price{
            display: flex;
            align-items: center;
        }

        .featured .box-container .box .content .price h3{
            font-size: 19px;
            margin-right: auto;
        }

        .featured .box-container .box .content .location{
            padding:1rem 0;
        }

        .featured .box-container .box .content .location h3{
            font-size: 18px;
            color:#333;
        }

        .featured .box-container .box .content .location p{
            font-size: 14px;
            color:#666;
            line-height: 1.5;
            padding-top: .5rem;
        }

        .featured .box-container .box .content .details{
            padding:.5rem 0;
            display: flex;
        }

        .featured .box-container .box .content .details h3{
            flex:1;
            padding:1rem;
            border:.1rem solid rgba(0,0,0,.1);
            color:#999;
            font-size: 13px;
            width: 5rem;
        }

        .featured .box-container .box .content .details h3 i{
            color:#333;
            padding-left: .5rem;
        }

        .featured .box-container .box .content .buttons{
            display: flex;
            gap:1rem;
        }

        .featured .box-container .box .content .buttons .btn{
            font-size: 14px;
        }

        @media screen and (max-width: 650px) {
            .featured .box-container .box {
                flex: 1;
            }
        }

        /* >>>>>>>>>>>>>>>>>>>>>>>> LOADER <<<<<<<<<<<<<<<<<<<<< */

        .loader-container {
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgb(187, 217, 247);
            display: grid;
            place-content: center;
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
        }

        .loader-container.hidden {
            opacity: 0;
            visibility: hidden;
        }

        #page-content {
            opacity: 0;
            transform: translate3d(0, -1rem, 0);
            transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
        }

        #page-content.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }

        .loader {
            width: 3rem;
            height: 3rem;
            border: 0.3rem solid rgb(49, 133, 218);
            border-left-color: transparent;
            border-right-color: transparent;
            border-radius: 50%;
            animation: 0.8s ease infinite alternate spinner;
        }

        @keyframes spinner {
            from{
                transform: rotate(0deg) scale(1);
            }

            to {
                transform: rotate(1turn) scale(1.2);
            }
        }

    </style>
</head>
<body id="page-content">
    <?php include_once "includes/loader.php";?>
    
    <!-- Navbar -->
    <?php include_once "includes/header.php";?>

    <!-- Search bar -->
    <form class="filter-form" action="search" method="post">
        <!-- 1) Text input with a flag icon -->
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                placeholder="Search listings (e.g., Apartment, House, Plot)"
                class="input"
            />
        </div>

        <select name="status" class="filter-select">
            <option value="">Select Status</option>
            <option value="for_rent">For Rent</option>
            <option value="for_sale">For Sale</option>
        </select>

        <select name="address" class="filter-select">
            <option value="">Select Town</option>
            <option value="Bulumkutu">Bulumkutu</option>
            <option value="Polo">Polo</option>
            <option value="Wulari">Wulari</option>
            <option value="Moduganari">Moduganari</option>
            <option value="Gomari">Gomari</option>
            <option value="Gwange">Gwange</option>
            <option value="Baga road">Baga road</option>
        </select>

        <!-- 3) Search button -->
        <button type="submit" name="searchSubmitBtn" class="search-btn">Search</button>
    </form>





    <section class="featured">
        <div class="box-container">
            <?php if(is_array($allListings) && count($allListings) > 0) : ?>
                <?php foreach($allListings as $listing) : ?>
                    <?php
                        $listingId = $listing['id'];
                        $image = $listings->getOneListingImage($listingId);
                        $image = $image['image_path'];
                    ?>
                    <div class="box">
                        <div class="image-container">
                            <img src="listing-images/<?=$image?>" alt="" />
                            <div class="info">
                                <?php if(isset($_SESSION['user']) && $_SESSION['role'] === 'admin') : ?>
                                    <h3>3 days ago</h3>
                                <?php endif;?>
                                <h3><?= ($listing['category'] == "for_rent") ? "For Rent" : "For Sale"; ?></h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="price">
                                <h3>#<?= number_format($listing['price'], 2) ?></h3>
                            </div>
                            <div class="location">
                                <h3><?= $listing['name'] ?></h3>
                                <p><?= $listing['address'] ?></p>
                            </div>
                            <div class="details">
                                <h3>sqft</h3>
                                <h3><?= $listing['bedrooms']?> beds</h3>
                                <h3><?= $listing['bathrooms']?> baths</h3>
                            </div>
                            <div class="buttons">
                                <form action="<?= ROOT_URL ?>view" method="post">
                                    <input type="hidden" name="listingId" value="<?= $listingId ?>">
                                    <button type="submit" class="btnL" name="view">View Details</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else :?>
                <h2>No listings found!</h2>
            <?php endif;?>
        </div>
    </section>
</body>
</html>