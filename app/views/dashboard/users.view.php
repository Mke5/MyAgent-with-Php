<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>

<?php

    use App\Models\User;

    $user = new User;

    $users = $user->getAll();

?>


<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="section-block">
                    <h3 class="section-title">All Users</h3>
                </div>
                <div class="card">
                    <div class="campaign-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0"></th>
                                    <th class="border-0">First Name</th>
                                    <th class="border-0">Last Name</th>
                                    <th class="border-0">No. Listings</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Date Created</th>
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) : ?>
                                    <tr>
                                        <td>
                                            <div class="m-r-10"><img src="<?= ASSETS ?>profile-pictures/<?= esc($user->image)?>" alt="user" width="35"></div>
                                        </td>
                                        <td><?= ucfirst(esc($user->fname))?></td>
                                        <td><?= ucfirst(esc($user->lname))?></td>
                                        <td><?= esc($user->total_listings)?></td>
                                        <td><?= esc($user->status)?></td>
                                        <td><?= esc($user->created_at)?></td>
                                        <td>
                                            <div class="dropdown float-right">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                            </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:void(0);" class="dropdown-item">Block</a>

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