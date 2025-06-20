
<?php

    use App\Models\User;
    use App\Models\Listing;

    $listingL = new Listing;
    $user = new User;

    if(isset($_POST['viewUser'])){
        
        if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
            redirect('home');
            exit;
        }

        $user = $user->findById(esc($_POST['user_id']));
    }else{
        redirect('home');
        exit;
    }

?>
<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>


<div class="dashboard-wrapper">

    <div class="container-fluid dashboard-content">

        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar text-center d-block">
                            <img src="<?= ASSETS ?>profile-pictures/<?= esc($user->image)?>" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                        </div>
                        <div class="text-center">
                            <h2 class="font-24 mb-0"><?= ucfirst(esc($user->fname)) ." ". ucfirst(esc($user->lname))?></h2>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3 class="font-16">Contact Information</h3>
                        <div class="">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-fw fa-envelope mr-2"></i><?= esc($user->email)?></li>
                                <!-- <li class="mb-0"><i class="fas fa-fw fa-phone mr-2"></i>(900) 123 4567</li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
                <div class="influence-profile-content pills-regular">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-campaign-tab" data-toggle="pill" href="#pills-campaign" role="tab" aria-controls="pills-campaign" aria-selected="true">Listings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-packages-tab" data-toggle="pill" href="#pills-packages" role="tab" aria-controls="pills-packages" aria-selected="false">For Sale</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-selected="false">For Rent</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-campaign" role="tabpanel" aria-labelledby="pills-campaign-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="section-block">
                                        <h3 class="section-title">My Listing State</h3>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1"><?= esc(count($listingL->findByUserId($user->id)))?></h1>
                                            <p>Total Listings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1"><?= esc(count($listingL->findByUserId($user->id)))?></h1>
                                            <p>Available Listings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1"><?= esc(count($listingL->findByCategoryAndUserId('for_rent' ,$user->id)))?></h1>
                                            <p>For Rent</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1"><?= esc(count($listingL->findByCategoryAndUserId('for_sale' ,$user->id)))?></h1>
                                            <p>For Sale</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-block">
                                <h3 class="section-title">All Listings</h3>
                            </div>
                            <?php if(count($listings = $listingL->findByUserId($user->id)) > 0) : ?>
                                <?php foreach($listings as $listing) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                        <div class="mr-4">
                                                        <?php $listingId = $listing->id; $image = $listingL->getImage($listingId);?>
                                                            <img src="<?=ASSETS?>listing-images/<?=$image->image?>" alt="listing image" class="user-avatar-lg">
                                                        </div>
                                                        <div class="media-body ">
                                                            <div class="influencer-profile-data">
                                                                <h3 class="m-b-10"><?= $listing->name?></h3>
                                                                <p>
                                                                    <span class="m-r-20 d-inline-block">Date Created
                                                                        <span class="m-l-10 text-primary"><?=$listing->created_at?></span>
                                                                    </span>
                                                                    <span class="m-r-20 d-inline-block"> Date Updated
                                                                        <span class="m-l-10 text-primary"><?=$listing->updated_at?></span>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top card-footer p-0">
                                            <div class="campaign-metrics d-xl-inline-block">
                                                <h4 class="mb-0"><?=$listing->views?></h4>
                                                <p>Total Views</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php else :?>
                                <h4 style="text-align: center;">No Listing Yet</h4>
                            <?php endif;?>
                        </div>
                        <div class="tab-pane fade" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                            <div class="section-block">
                                <h3 class="section-title">For Sale</h3>
                            </div>
                            <?php if(count($listingL->findByCategoryAndUserId('for_sale' ,$user->id)) > 0) : ?>
                                <?php foreach($listings as $listing) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                        <div class="mr-4">
                                                        <?php $listingId = $listing->id; $image = $listingL->getImage($listingId);?>
                                                            <img src="<?=ASSETS?>listing-images/<?=$image->image?>" alt="listing image" class="user-avatar-lg">
                                                        </div>
                                                        <div class="media-body ">
                                                            <div class="influencer-profile-data">
                                                                <h3 class="m-b-10"><?= $listing->name?></h3>
                                                                <p>
                                                                    <span class="m-r-20 d-inline-block">Date Created
                                                                        <span class="m-l-10 text-primary"><?=$listing->created_at?></span>
                                                                    </span>
                                                                    <span class="m-r-20 d-inline-block"> Date Updated
                                                                        <span class="m-l-10 text-primary"><?=$listing->updated_at?></span>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top card-footer p-0">
                                            <div class="campaign-metrics d-xl-inline-block">
                                                <h4 class="mb-0"><?=$listing->views?></h4>
                                                <p>Total Views</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php else :?>
                                <h4 style="text-align: center;">No Listing Yet</h4>
                            <?php endif;?>
                        </div>
                        <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                        <div class="section-block">
                                <h3 class="section-title">For Rent</h3>
                            </div>
                            <?php if(count($listingL->findByCategoryAndUserId('for_rent' ,$user->id)) > 0) : ?>
                                <?php foreach($listings as $listing) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                        <div class="mr-4">
                                                        <?php $listingId = $listing->id; $image = $listingL->getImage($listingId);?>
                                                            <img src="<?=ASSETS?>listing-images/<?=$image->image?>" alt="listing image" class="user-avatar-lg">
                                                        </div>
                                                        <div class="media-body ">
                                                            <div class="influencer-profile-data">
                                                                <h3 class="m-b-10"><?= $listing->name?></h3>
                                                                <p>
                                                                    <span class="m-r-20 d-inline-block">Date Created
                                                                        <span class="m-l-10 text-primary"><?=$listing->created_at?></span>
                                                                    </span>
                                                                    <span class="m-r-20 d-inline-block"> Date Updated
                                                                        <span class="m-l-10 text-primary"><?=$listing->updated_at?></span>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top card-footer p-0">
                                            <div class="campaign-metrics d-xl-inline-block">
                                                <h4 class="mb-0"><?=$listing->views?></h4>
                                                <p>Total Views</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php else :?>
                                <h4 style="text-align: center;">No Listing Yet</h4>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include_once "includes/footer.php"?>
</div>

<?php include_once "includes/foot.php"?>