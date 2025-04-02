<?php
    require_once "../app/core/init.php";

    use app\models\Listing;
    $session = new Core\Session;

    $listings = new Listing();
    $searchedListings = [];


    if (isset($_POST['searchSubmitBtn']) && isset($_POST['search'])) {
        # code...
        $search = trim(esc($_POST['search']) ?? null);
        $address = trim(esc($_POST['address']) ?? null);
        $status = trim(esc($_POST['status']) ?? null);

        if(!empty($search) || !empty($address) || !empty($status)){
            
            $searchedListings = $listings->searchListing($search, $address, $status);
                   
        }else {

            $searchedListings = $listings->getAll();
            
        }
    } else {
        # code...
        header('location: ' . ROOT_URL .'listing');
        die();
    }

    include_once 'dashboard/includes/states.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Details</title>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/index.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/listing.css">
    <style>
        *{
            padding: 0;
            margin: 0;
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

        /* >>>>>>>>>>>>>>>>>>>>> END OF LOADER <<<<<<<<<<<<<<<<<<<< */

        
        .card-wrapper {
            max-width: 1024px;
            margin: 0 auto;
            margin-top: 1rem;
        }
        img {
            width: 100%;
            display: block;
        }

        .img-display {
            overflow: hidden;
        }
                
        .img-showcase {
            display: flex;
            width: 80vh;
            height: 60vh;
            transition: all 0.5s ease;
            object-fit: cover;
            object-position: center;
        }

        .img-showcase img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            height: fit-content;
        }

        .img-select {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .img-item{
            margin: 0.3rem;
            overflow: hidden;
            height: 6rem;
            min-height: 6rem;
            max-height: 6rem;
        }

        .img-item img {
            scale: 1.2;
            transition: all 300ms ease-in-out;
        }

        .img-item:nth-child(1),
        .img-item:nth-child(2),
        .img-item:nth-child(3),
        .img-item:nth-child(4),
        .img-item:nth-child(5) {
            margin-right: 0;
        }

        .img-item:hover img{
            scale: 1;
        }

        .product-content {
            padding: 2rem 1rem;
        }

        .product-title {
            font-size: 3rem;
            font-weight: 700;
            position: relative;
            color: #12263a;
            margin: 1rem 0;
        }

        .product-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            background: #12263a;
            width: 80px;
            height: 4px;
        }

        .product-price {
            margin: 1rem 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .product-price span {
            font-weight: 500;
        }

        .product-details h2 {
            color: #12263a;
            padding-bottom: 0.6rem;
        }

        .product-details p {
            font-size: 0.9rem;
            padding: 0.3rem;
        }

        .product-details ul {
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .product-details ul li {
            margin: 0;
            list-style: none;
            background: url(images/icon-arrow-right-color.svg) left center no-repeat;
            background-size: 18px;
            padding-left: 1.7rem;
            margin: 0.4rem 0;
            font-weight: 600;
        }

        .product-details ul li span {
            font-weight: 500;
        }

        .purchase-info {
            margin: 1.5rem;
        }

        .purchase-info a {
            padding: 0.45rem 0.8rem;
            text-align: center;
            text-decoration: none;
            color: white;
            cursor: pointer;
            background: #12263a;
            border-radius: 5px;
            display: inline-block;
            transition: all 300ms ease;
        }

        .purchase-info a:hover {
            box-shadow: 1px 1px 13px #0000006f;
            transform: translate(0, -0.5rem);
        }

        .img-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.8rem;
            overflow: hidden;
        }

        .img-btn img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            object-position: center;
            cursor: pointer;
        }

        .author-info {
            display: flex;
            gap: 1rem;
            align-items: center;
            cursor: pointer;
        }

        @media screen and (min-width: 992px) {
            .card {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .card-wrapper {
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .product-imgs {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 1rem;
            }

            .product-content {
                padding-top: 0;
            }
        }

        .listing-grid {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .listing-item {
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        .listing-item:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .listing-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .listing-info {
            padding: 1rem;
        }

        .listing-info h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .listing-info .location {
            font-size: 0.9rem;
            color: #777;
        }

        .listing-info .price {
            font-size: 1.1rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .listing-info .description {
            font-size: 0.9rem;
            color: #555;
        }

        .listing-info .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #7380ec;
            color: white;
            border: none;
            border-radius: 0.3rem;
            margin-top: 1rem;
            text-align: center;
            cursor: pointer;
        }

        .listing-info .btn:hover {
            background-color: #5763d3;
        }

        .featured .box-container{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap:1.5rem;
        }

        @media screen and (min-width: 1200px) { 
    .featured .box-container {
        grid-template-columns: repeat(4, 1fr); /* Force 5 cards per row on large screens */
    }
}

@media screen and (max-width: 1024px) { 
    .featured .box-container {
        grid-template-columns: repeat(4, 1fr); /* 4 cards per row on medium screens */
    }
}

@media screen and (max-width: 768px) { 
    .featured .box-container {
        grid-template-columns: repeat(3, 1fr); /* 3 cards per row on tablets */
    }
}

@media screen and (max-width: 600px) { 
    .featured .box-container {
        grid-template-columns: repeat(2, 1fr); /* 2 cards per row on small screens */
    }
}

@media screen and (max-width: 400px) { 
    .featured .box-container {
        grid-template-columns: repeat(1, 1fr); /* 1 card per row on very small screens */
    }
}


    </style>
</head>
<body id="page-content">

    <?php include_once "includes/loader.php";?>
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
            <?php if(isset($_SESSION['user']) && $_SESSION['role'] === "admin") : ?>
                <option value="rented">Rented</option>
                <option value="sold">Sold</option>
            <?php endif;?>
            <option value="for_sale">For Sale</option>
        </select>

        <select name="address" class="filter-select">
            <option value="">State</option>
            <?php foreach ($states as $state => $lgas): ?>
                <option value="<?= $state ?>"><?= $state ?></option>
            <?php endforeach; ?>
        </select>

        <!-- 3) Search button -->
        <button type="submit" name="searchSubmitBtn" class="search-btn">Search</button>
    </form>


    
    
    <section class="featured">
        <div class="box-container">
            <?php if(count($searchedListings) > 0) : ?>
                <?php foreach($searchedListings as $listing) : ?>
                    <?php
                        $listingId = $listing->id;
                        $image = $listings->getImage($listingId);
                        $image = $image->image;
                        $action = ROOT_URL.'listing-details.php';
                    ?>
                    <div class="box">
                        <div class="image-container">
                            <img src="<?=ASSETS?>listing-images/<?=$image?>" alt="" />
                            <div class="info">
                                <?php if($session->is_logged_in() && $session->user('role') == 'admin') : ?>
                                    <h3><?=$listings->timeAgo($listing->created_at)?></h3>
                                <?php endif;?>
                                <h3><?= $listing->category == 'for_sale' ? 'for Sale' : 'for Rent'?></h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="price">
                                <h3>#<?= number_format($listing->price, 2) ?></h3>
                            </div>
                            <div class="location">
                                <h3><?= $listing->name ?></h3>
                                <p><?= $listing->address ?></p>
                            </div>
                            <div class="details">
                                <h3>sqft</h3>
                                <h3><?= $listing->bedroom?> beds</h3>
                                <h3><?= $listing->bathroom?> baths</h3>
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
                <h2 style="text-align: center;margin: auto;">No listing found!</h2>
            <?php endif;?>
        </div>
    </section>
</body>
</html>