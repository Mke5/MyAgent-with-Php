<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>

<div class="dashboard-wrapper">

    <div class="container-fluid dashboard-content">

        <div class="row">
            <!-- ============================================================== -->
            <!-- profile -->
            <!-- ============================================================== -->
            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- card profile -->
                <!-- ============================================================== -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar text-center d-block">
                            <img src="assets/images/avatar-1.jpg" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                        </div>
                        <div class="text-center">
                            <h2 class="font-24 mb-0">Michael J. Christy</h2>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3 class="font-16">Contact Information</h3>
                        <div class="">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-fw fa-envelope mr-2"></i>michaelchristy@gmail.com</li>
                                <li class="mb-0"><i class="fas fa-fw fa-phone mr-2"></i>(900) 123 4567</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end card profile -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- end profile -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- campaign data -->
            <!-- ============================================================== -->
            <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- campaign tab one -->
                <!-- ============================================================== -->
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
                                            <h1 class="mb-1">9</h1>
                                            <p>Total Listings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1">35</h1>
                                            <p>Available Listings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1">8</h1>
                                            <p>For Rent</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1">1</h1>
                                            <p>For Sale</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-block">
                                <h3 class="section-title">All Listings</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                <div class="mr-4">
                                                    <img src="assets/images/slack.png" alt="listing image" class="user-avatar-lg">
                                                </div>
                                                <div class="media-body ">
                                                    <div class="influencer-profile-data">
                                                        <h3 class="m-b-10">Your Campaign Title Here</h3>
                                                        <p>
                                                            <span class="m-r-20 d-inline-block">Draft Due Date
                                                                <span class="m-l-10 text-primary">24 Jan 2018</span>
                                                            </span>
                                                            <span class="m-r-20 d-inline-block"> Publish Date
                                                                <span class="m-l-10 text-secondary">30 Feb 2018</span>
                                                            </span>
                                                                <span class="m-r-20 d-inline-block">Ends <span class="m-l-10  text-info">30 May, 2018</span>
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
                                        <h4 class="mb-0">45k</h4>
                                        <p>Total Reach</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">29k</h4>
                                        <p>Total Views</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">5k</h4>
                                        <p>Total Click</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">4k</h4>
                                        <p>Engagement</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">2k</h4>
                                        <p>Conversion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                            <div class="section-block">
                                <h3 class="section-title">For Sale</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                <div class="mr-4">
                                                    <img src="assets/images/slack.png" alt="listing image" class="user-avatar-lg">
                                                </div>
                                                <div class="media-body ">
                                                    <div class="influencer-profile-data">
                                                        <h3 class="m-b-10">Your Campaign Title Here</h3>
                                                        <p>
                                                            <span class="m-r-20 d-inline-block">Draft Due Date
                                                                <span class="m-l-10 text-primary">24 Jan 2018</span>
                                                            </span>
                                                            <span class="m-r-20 d-inline-block"> Publish Date
                                                                <span class="m-l-10 text-secondary">30 Feb 2018</span>
                                                            </span>
                                                                <span class="m-r-20 d-inline-block">Ends <span class="m-l-10  text-info">30 May, 2018</span>
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
                                        <h4 class="mb-0">45k</h4>
                                        <p>Total Reach</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">29k</h4>
                                        <p>Total Views</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">5k</h4>
                                        <p>Total Click</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">4k</h4>
                                        <p>Engagement</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">2k</h4>
                                        <p>Conversion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                        <div class="section-block">
                                <h3 class="section-title">For Rent</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="media influencer-profile-data d-flex align-items-center p-2">
                                                <div class="mr-4">
                                                    <img src="assets/images/slack.png" alt="listing image" class="user-avatar-lg">
                                                </div>
                                                <div class="media-body ">
                                                    <div class="influencer-profile-data">
                                                        <h3 class="m-b-10">Your Campaign Title Here</h3>
                                                        <p>
                                                            <span class="m-r-20 d-inline-block">Draft Due Date
                                                                <span class="m-l-10 text-primary">24 Jan 2018</span>
                                                            </span>
                                                            <span class="m-r-20 d-inline-block"> Publish Date
                                                                <span class="m-l-10 text-secondary">30 Feb 2018</span>
                                                            </span>
                                                                <span class="m-r-20 d-inline-block">Ends <span class="m-l-10  text-info">30 May, 2018</span>
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
                                        <h4 class="mb-0">45k</h4>
                                        <p>Total Reach</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">29k</h4>
                                        <p>Total Views</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">5k</h4>
                                        <p>Total Click</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">4k</h4>
                                        <p>Engagement</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">2k</h4>
                                        <p>Conversion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include_once "includes/footer.php"?>
</div>

<?php include_once "includes/foot.php"?>