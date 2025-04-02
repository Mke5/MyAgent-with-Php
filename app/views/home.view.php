<?php

    require_once "../app/core/init.php";

    use app\models\User;
    use app\models\Listing;

    $user = new User();
    $listings = new Listing();



    if(isset($_SESSION['USER'])){
        $userId = $_SESSION['USER']['id']; // Ensure 'id' is correct
        
        if(!$user->findById($userId)){
            session_unset();
            session_destroy();
            session_regenerate_id(true);
        }
    }
    
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyAgent</title>
    <link rel="stylesheet" href="<?= ASSETS ?>css/index.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/header.css">
</head>
<body id="page-content">
    <?php include_once "includes/loader.php";?>

    <div>
        <!-- Navbar -->
        <?php include_once "includes/header.php";?>
    
    
        <!-- First Hero Section: Welcome Message + Image Slider -->
        <section class="hero-1">
            <div class="hero-left">
                <h1>Find your next Perfect Place with ease</h1>
                <p>Your perfect home is waiting for you. Find, explore, and make your dream home a reality today.</p>
                <a href="<?=ROOT_URL?>/listing" class="btn-primary">Get Started</a>
                
            </div>
            <div class="hero-right">
                <div class="image">
                    <?php
                        $randomListings = $listings->getRandomListing();
                    ?>
                        <?php foreach ($randomListings as $listing) : ?>
                            <?php
                                $listingId = $listing->id;
                                $listingImage = $listings->getImage($listingId);
                                $imagePath = $listingImage ? $listingImage->image : 'default.jpg'; // Use fallback image if null
                            ?>
                            <form action="<?= ROOT_URL ?>/view" method="post">
                                <input type="text" value="<?=$listingId?>" name="listingId" hidden>
                                <button name="view">
                                    <img src="<?=ASSETS?>/listing-images/<?=$imagePath?>" alt="">
                                </button>
                            </form>
                        <?php endforeach; ?>
                </div>
            </div>
        </section>
    
    
    
        <!-- Second Hero Section: Image List with Hover Effects -->
        <section class="hero-2">
                <?php $_listings = $listings->getRandomListing();?>
            <h2>Featured Properties</h2>
            <div class="property-list">

                <?php foreach($_listings as  $_listing) : ?>
                    <?php
                        $listingId = $_listing->id;
    
                        $image = $listings->getImage($listingId);
                    ?>
                     
                    <form action="<?= ROOT_URL ?>/view" method="post">
                        <input name="listingId" type="text" value="<?=$listingId?>" hidden>
                        <button name="view" class="property-item">
                            <img src="<?=ASSETS?>/listing-images/<?=$image->image?>" alt="Property 1">
                            <figcaption>
                                <main>
                                    <p class="small">
                                        <?php
                                            if ($_listing->category == "for_rent") {
                                                echo "For Rent";
                                            } else {
                                                echo "For Sale";
                                            }                                            
                                        ?>
                                    </p>
                                    <h3><?=$listing->name?>, <em><?=$listing->state?></em></h3>
                                    <p><?= substr($listing->description, 0, 10) ?>...</p>
                                </main>
    
                                <div class="footer">
                                    <div>
                                        <p class="small">From</p>
                                        <p class="price">#<?= $listing->price?></p>
                                    </div>
    
                                    <a>
                                        <img src="<?= ASSETS ?>/images/icon-arrow-right-color.svg" alt="Icon">
                                    </a>
                                </div>
                            </figcaption>
                        </button>
                    </form>
                    
                <?php endforeach; ?>
    
            </div>
        </section>
    
        <!-- Footer -->
        <footer>
            <p>&copy; 2023 - <?= date("Y"); ?> MyAgent. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>