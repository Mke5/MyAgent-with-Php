<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card p-4">
                    <form action="<?=ROOT_URL?>/dashboard/search" method="post">
                        <div class="row">
                            <!-- Search Bar -->
                            <div class="col-md-6 mb-1">
                                <input class="form-control form-control-sm" type="search" placeholder="Search Listings or Agents" aria-label="Search">
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Property Type</option>
                                    <option>Apartment</option>
                                    <option>House</option>
                                    <option>Office</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Property Type</option>
                                    <option>Apartment</option>
                                    <option>House</option>
                                    <option>Office</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!-- Listing Filters -->
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Property Type</option>
                                    <option>Apartment</option>
                                    <option>House</option>
                                    <option>Office</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Location</option>
                                    <option>New York</option>
                                    <option>Los Angeles</option>
                                    <option>Chicago</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Price Range</option>
                                    <option>$500 - $1000</option>
                                    <option>$1000 - $2000</option>
                                    <option>$2000 - $5000</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Bedrooms</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3+</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!-- Agent Filters -->
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Agent Type</option>
                                    <option>Verified</option>
                                    <option>Independent</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Experience</option>
                                    <option>1-3 Years</option>
                                    <option>3-5 Years</option>
                                    <option>5+ Years</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <select class="form-control form-control-sm">
                                    <option selected disabled>Rating</option>
                                    <option>4+ Stars</option>
                                    <option>3+ Stars</option>
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-1">
                                <button class="btn btn-primary btn-sm btn-block" type="submit">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "includes/footer.php"?>
</div>
<?php include_once "includes/foot.php"?>