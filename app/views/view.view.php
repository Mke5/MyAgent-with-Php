<?php

  require_once '../core/init.php';

  use App\Models\Listing;

  $listings = new Listing();
  $listingId = 0;

  // Security headers to prevent XSS and clickjacking attacks
  header("Content-Security-Policy: default-src 'self'; img-src 'self' data:;");
  header("X-Frame-Options: DENY");
  header("X-Content-Type-Options: nosniff");

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view'])) {
    $listingId = (int)filter_var($_POST['listingId'], FILTER_VALIDATE_INT);
  }elseif (isset($_GET['listing_id'])) {
    $listingId = (int)filter_var($_GET['listingId'], FILTER_VALIDATE_INT);
  }


  if (!$listingId || $listingId <= 0) {
    http_response_code(400);
    die("Invalid listing!");
  }
    
  $listing = $data['listing'];
  $firstImg = $data['firstImg'];
  $allImg = $data['allImg'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($listing['name']); ?> | MyAgent</title>
    <meta name="description" content="View details of <?= esc($listing['name']); ?>, located at <?= esc($listing['address']); ?>.">
    <link rel="stylesheet" href="<?=ASSETS?>/css/Vstyle.css">
</head>
<body>
  <main>
    <div class="container">
        <h1 class="car-details-page-title"><?= esc($listing['name']); ?></h1>
        <div class="car-details-region"><?= $listing['address']?> - <?= $listings->timeAgo($listing['date_created'])?></div>

        <div class="car-details-content">
          <div class="car-images-and-description">
            <div class="car-images-carousel">
              <div class="car-image-wrapper">
                <img
                  src="<?= ROOT_URL ?>listing-images/<?= $firstImg['image_path']?>"
                  alt=""
                  class="car-active-image"
                  id="activeImage"
                />
              </div>
              <div class="car-image-thumbnails">
                <?php foreach($allImg as $img) : ?>
                  <img src="<?= ROOT_URL ?>listing-images/<?= $img['image_path']?>" alt="" />
                <?php endforeach;?>
              </div>
              <button class="carousel-button prev-button" id="prevButton">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  style="width: 64px"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 19.5 8.25 12l7.5-7.5"
                  />
                </svg>
              </button>
              <button class="carousel-button next-button" id="nextButton">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  style="width: 64px"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                  />
                </svg>
              </button>
            </div>

            <div class="card car-detailed-description">
              <h2 class="car-details-title">Detailed Description</h2>
              <p>
                <?= $listing['description']?>
              </p>
            </div>

          </div>
          <div class="car-details card">
            <div class="flex items-center justify-between">
              <p class="car-details-price">$<?= esc($listing['price'])?></p>
            </div>

            <hr />
            <table class="car-details-table">
              <tbody>
                <tr>
                  <th>Category</th>
                  <td><?= esc($listing['category'])?></td>
                </tr>
                <tr>
                  <th>Bedrooms</th>
                  <td><?= esc($listing['bedrooms'])?></td>
                </tr>
                <tr>
                  <th>Bathrooms</th>
                  <td><?= esc($listing['bathrooms'])?></td>
                </tr>
                <tr>
                  <th>Sittingrooms</th>
                  <td><?= esc($listing['sittingroom'])?></td>
                </tr>
                <tr>
                  <th>Kitchens</th>
                  <td><?= esc($listing['kitchen'])?></td>
                </tr>
              </tbody>
            </table>
            <hr />

            <div class="flex gap-1 my-medium">
              <button class="btn">Copy Link</button>
            </div>
            <a href="" class="car-details-phone">
              Contact Agent
            </a>
          </div>
        </div>
      </div>
  </main>


  <script src="<?=ASSETS?>/js/Vapp.js"></script>
</body>
</html>