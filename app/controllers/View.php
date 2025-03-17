<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use App\Models\Listing;

/**
 * View class
 */
// class View extends Controller
// {
//     public function index()
//     {
//         $listingId = null;

//         // Check if request is POST or GET
//         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['listingId'])) {
//             $listingId = (int) filter_var($_POST['listingId'], FILTER_VALIDATE_INT);
//         } elseif (isset($_GET['listing_id'])) {
//             $listingId = (int) filter_var($_GET['listing_id'], FILTER_VALIDATE_INT);
//         }

//         // Validate the listing ID
//         if (!$listingId || $listingId <= 0) {
//             http_response_code(400);
//             die("Invalid listing!");
//         }

//         $listings = new Listing();
//         $listing = $listings->findById($listingId);
//         $firstImg = $listings->getOneListingImage($listingId);
//         $allImg = $listings->getListingImages($listingId);

//         if (!$listing) {
//             http_response_code(404);
//             die("Listing not found!");
//         }

//         // Pass listing details to the view
//         $this->view('view', [
//             'listing' => $listing,
//             'firstImg' => $firstImg,
//             'allImg' => $allImg
//         ]);
//     }
// }

class View extends Controller
{
    public function index($requestData = [])
    {
        $listings = new Listing();
        $listingId = 0;

        // Get listing ID from GET or POST request
        if (!empty($requestData['listing_id'])) {
            $listingId = (int) filter_var($requestData['listing_id'], FILTER_VALIDATE_INT);
        }

        if (!$listingId || $listingId <= 0) {
            http_response_code(400);
            die("Invalid listing!");
        }

        // Fetch listing details
        $listing = $listings->findById($listingId);
        $firstImg = $listings->getOneListingImage($listingId);
        $allImg = $listings->getListingImages($listingId);

        // Pass data to the view
        $this->view('view', [
            'listing' => $listing,
            'firstImg' => $firstImg,
            'allImg' => $allImg
        ]);
    }
}