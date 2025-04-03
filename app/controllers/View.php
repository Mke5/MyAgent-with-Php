<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use App\Models\Listing;

class View extends Controller
{
    public function index()
    {
        $listings = new Listing();
        $listingId = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['listingId'])) {
            $listingId = (int) filter_var($_POST['listingId'], FILTER_VALIDATE_INT);

            $listing = $listings->findById($listingId);
            if($listing != []){
                $firstImg = $listings->getImage($listingId);
                $allImg = $listings->getImages($listingId);
                
                // Pass data to the view
                $this->view('view', [
                    'listing' => $listing,
                    'firstImg' => $firstImg,
                    'allImg' => $allImg
                ]);
    
            }else{
                $this->view('404');
                die;
            }
        } elseif (isset($_GET['listing'])) {
            $listingId = esc(filter_var($_GET['listing'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $listing = $listings->findByLink($listingId);
            if($listing != []){
                $firstImg = $listings->getImage($listing->id);
                $allImg = $listings->getImages($listing->id);
                
                // Pass data to the view
                $this->view('view', [
                    'listing' => $listing,
                    'firstImg' => $firstImg,
                    'allImg' => $allImg
                ]);
    
            }else{
                $this->view('404');
                die;
            }
        }

        if (!$listingId || $listingId <= 0) {
            redirect($_SERVER['HTTP_REFERER']);
            die;
        }
        
        die;
    }
}