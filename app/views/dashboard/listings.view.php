<?php

    use App\Models\Listing;

    $listingL = new Listing;

    $listings = $listingL->getAll();

?>

<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>    


<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="section-block">
                    <h3 class="section-title">All Listings</h3>
                </div>
                <?php if(count($listings) > 0):?>
                    <div class="card">
                        <div class="campaign-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="border-0">
                                        <th class="border-0"></th>
                                        <th class="border-0">Listing Name</th>
                                        <th class="border-0">Agent</th>
                                        <th class="border-0">Views</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Date Created</th>
                                        <th class="border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($listings as $listing) : ?>
                                        <?php $listingId = $listing->id; $image = $listingL->getImage($listingId);?>
                                        <tr>
                                            <td>
                                                <div class="m-r-10"><img src="<?=ASSETS?>listing-images/<?=$image->image?>" alt="Listing" width="35"></div>
                                            </td>
                                            <td><?=esc(ucfirst($listing->name))?></td>
                                            <td><?php $user = $listingL->getUser($listing->author_id); echo ucfirst($user->fname)." ".ucfirst($user->lname)?></td>
                                            <td><?=$listing->views?></td>
                                            <td><?= esc($listing->category)?></td>
                                            <td><?= esc($listing->created_at)?></td>
                                            <td>
                                                <div class="dropdown float-right">
                                                    <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <form action="<?=ROOT_URL?>/view" method="post">
                                                            <input type="text" value="<?= $listing->id?>" name="listing_id" hidden>
                                                            <button class="dropdown-item" name="viewListing">View</button>
                                                        </form>

                                                        <form action="<?=ROOT_URL?>/dashboard/user" method="post">
                                                            <input type="text" value="<?= $user->id?>" name="user_id" hidden>
                                                            <button class="dropdown-item" name="viewUser">View Agent</button>
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
                <?php else:?>
                    <h3 style="text-align: center;">No listings yet</h3>
                <?php endif?>
            </div>
        </div>
    </div>

    <?php include_once "includes/footer.php"?>
</div>

<?php include_once "includes/foot.php"?>