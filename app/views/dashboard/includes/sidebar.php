<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="<?=ROOT_URL?>/dashboard/index">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?=$_SERVER['REQUEST_URI']=='/MyAgent/dashboard/index' ? 'active' :''?>" href="<?=ROOT_URL?>/dashboard/index"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Manage Listings</a>
                        <div id="submenu-2" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?=$_SERVER['REQUEST_URI']=='/MyAgent/dashboard/createlisting' ? 'active' :''?>" href="<?=ROOT_URL?>/dashboard/createlisting">Create House Listing</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=ROOT_URL?>/dashboard/searchlisting">Search Listing</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-2"><i class="fas fa-fw fa-chart-pie"></i>Manage Users</a>
                        <div id="submenu-3" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=ROOT_URL?>/dashboard/viewusers">View Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Add Admin</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- <li class="nav-item ">
                        <a class="nav-link" href="#"><i class="fab fa-fw fa-wpforms"></i>Profile</a>
                    </li> -->
                    
                    <li class="nav-item">
                        <a class="nav-link <?=$_SERVER['REQUEST_URI']=='/MyAgent/dashboard/listings' ? 'active' :''?>" href="<?=ROOT_URL?>/dashboard/listings"><i class="fas fa-fw fa-table"></i>All Listings</a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </div>
</div>