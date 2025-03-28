<?php

    use App\Models\User;
    use App\Models\Listing;

    $listing = new Listing;

    $user = new User;


    $users = $user->getAll();

?>        
        
        <?php include_once "includes/header.php"?>

        <?php include_once "includes/sidebar.php"?>    

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">

                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Total Agents</h5>
                                    <h2 class="mb-0"><?=esc(count($user->getAll()))?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                    <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Total Listings</h5>
                                    <h2 class="mb-0"><?=esc(count($listing->getAll()))?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-home fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Total Visits</h5>
                                    <h2 class="mb-0"> 24,763</h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                <i class="fa fa-chart-bar fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Total Listings</h5>
                                    <h2 class="mb-0"> 24,763</h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-home fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                
                <div class="row">
                    <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Top Viewed Listings</h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">#</th>
                                                <th class="border-0">Img</th>
                                                <th class="border-0">Listing Name</th>
                                                <th class="border-0">Listing Id</th>
                                                <th class="border-0">Price</th>
                                                <th class="border-0">Category</th>
                                                <th class="border-0">Author</th>
                                                <th class="border-0">Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php #$listingViews = $listing->views(); if(count($listing->views()) > 0) :?>
                                                <?php #foreach($listingViews as $listing) : ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="m-r-10"><img src="<?= ROOT_URL?>listing-images/<?php ?>" alt="user" class="rounded" width="45"></div>
                                                        </td>
                                                        <td><?#$listing['name']?></td>
                                                        <td><?#$listing['price']?></td>
                                                        <td><?#$listing['id']?> </td>
                                                        <td><?#$listing['category']?></td>
                                                        <td><?#$listing['author_id']?></td>
                                                        <td><?#$listing['date_created']?></td>
                                                    </tr>
                                                <?php # endforeach;?>
                                            <?php #endif;?> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Most Liked Listings</h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">#</th>
                                                <th class="border-0">Image</th>
                                                <th class="border-0">Product Name</th>
                                                <th class="border-0">Product Id</th>
                                                <th class="border-0">Price</th>
                                                <th class="border-0">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                </td>
                                                <td>Product #1 </td>
                                                <td>id000001 </td>
                                                <td>$80.00</td>
                                                <td><a href="">view</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-block">
                            <h3 class="section-title">Active Agents</h3>
                        </div>
                        <div class="card">
                            <div class="campaign-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0"></th>
                                            <th class="border-0">Agent's Name</th>
                                            <th class="border-0">No. Listings</th>
                                            <th class="border-0">Date Joined</th>
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($users as $user) : ?>
                                            <tr>
                                                <td>
                                                    <div class="m-r-10"><img src="<?= ASSETS ?>profile-pictures/<?= esc($user->image)?>" alt="user" width="35"></div>
                                                </td>
                                                <td><?= ucfirst(esc($user->fname))?> <?= ucfirst(esc($user->lname))?></td>
                                                <td><?= esc($user->total_listings)?></td>
                                                <td><?= esc($user->created_at)?></td>
                                                <td>
                                                    <div class="dropdown float-right">
                                                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="javascript:void(0);" class="dropdown-item">Block</a>
                                                            <!-- <a href="<?= ROOT_URL?>/dashboard/user" class="dropdown-item">view</a> -->
                                                            <form action="<?=ROOT_URL?>/dashboard/user" method="post">
                                                                <input type="text" value="<?= $user->id?>" name="user_id" hidden>
                                                                <button class="dropdown-item" name="viewUser">view</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include_once "includes/footer.php"?>
        </div>
<?php include_once "includes/foot.php"?>