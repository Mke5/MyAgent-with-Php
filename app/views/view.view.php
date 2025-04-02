<?php

  require_once "../app/core/init.php";

  use App\Models\Listing;

  $listings = new Listing();

    
  $listing = $data['listing'];
  $firstImg = $data['firstImg'];
  $allImg = $data['allImg'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(esc($listing->name)) ?> | MyAgent</title>
    <meta name="description" content="View details of <?= esc($listing->name); ?>, located at <?= esc($listing->state); ?>.">
    <link rel="stylesheet" href="<?=ASSETS?>/css/Vstyle.css">
</head>
<body>
  <main>
    <div class="container">
        <h1 class="car-details-page-title"><?= ucfirst(esc($listing->name)); ?></h1>
        <div class="car-details-region"><?= $listing->lga." - ". $listing->state?> - <?= $listings->timeAgo($listing->created_at)?></div>

        <div class="car-details-content">
          <div class="car-images-and-description">
            <div class="car-images-carousel">
              <div class="car-image-wrapper">
                <img
                  src="<?= ASSETS?>listing-images/<?= $firstImg->image?>"
                  alt=""
                  class="car-active-image"
                  id="activeImage"
                />
              </div>
              <div class="car-image-thumbnails">
                <?php foreach($allImg as $img) : ?>
                  <img src="<?= ASSETS ?>listing-images/<?= $img->image?>" alt="" />
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
                <?= $listing->description?>
              </p>
            </div>

          </div>
          <div class="car-details card">
            <div class="flex items-center justify-between">
              <p class="car-details-price">₦<?= esc(number_format((float) $listing->price, 2, '.', ','))?></p>
            </div>

            <hr />
            <table class="car-details-table">
              <tbody>
                <tr>
                  <th>Category</th>
                  <td><?= esc($listing->category)?></td>
                </tr>
                <tr>
                  <th>Bedrooms</th>
                  <td><?= esc($listing->bedroom)?></td>
                </tr>
                <tr>
                  <th>Bathrooms</th>
                  <td><?= esc($listing->bathroom)?></td>
                </tr>
                <tr>
                  <th>Sittingrooms</th>
                  <td><?= esc($listing->sittingroom)?></td>
                </tr>
                <tr>
                  <th>Kitchens</th>
                  <td><?= esc($listing->kitchen)?></td>
                </tr>
              </tbody>
            </table>
            <hr />

            <div class="flex gap-1 my-medium">
              <a href="<?=ROOT_URL?>/view?listing=<?=$listing->link?>" onclick="copyToClipboard(this.href); return false;" class="btn">Copy Link</a>
            </div>

            <script>
              function copyToClipboard(text) {
                navigator.clipboard.writeText(text)
                  .then(() => alert('Link copied: ' + text))
                  .catch(err => console.error('Failed to copy: ', err));
              }
            </script>
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