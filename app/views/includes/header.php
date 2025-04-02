<?php

    require_once "../app/core/init.php";

    use app\models\User;
    use app\models\Listing;
    use Core\Session;

    $user = new User();
    $listings = new Listing();
    $session = new Session();


    if($session->is_logged_in()){
        $userId = $session->user('id');
        
        if(!$user->findById($userId)){
            session_unset();
            session_destroy();
            session_regenerate_id(true);
        }
    }
    

    $profilePicture = ASSETS . "profile-pictures/" . esc($user->getUserImage($userId));

    if(isset($userId)){
        $userImg = esc($user->getUserImage($userId));
        if($session->user('role') === "admin") {
            $profilePicture = ASSETS . 'profile-pictures/' . $userImg;
        } elseif(null !== ($userImg) && !empty($userImg) && file_exists('profile-pictures/' . $userImg)) {
            $profilePicture = ASSETS . 'profile-pictures/' . $userImg;
        }
    }
?>

<header>

    <!-- Mobile Navbar -->
    <nav class="mobile">
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
            </svg>
        </label>

        <label id="overlay" for="sidebar-active"></label>

        <div class="links-container">
            <label for="sidebar-active" class="close-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </label>

            <a href="<?= ROOT_URL ?>" style="margin-bottom: 2rem;">MyAgent</a>
            <a href="<?= ROOT_URL ?>/listings">Listings</a>
            <a href="<?= ROOT_URL ?>/about">About</a>

            <?php if($session->user('role')): ?>
                
                <a href="<?= ROOT_URL ?>/dashboard">Profile</a>
                
                <a href="<?= ROOT_URL ?>/logout">Logout</a>
            <?php else: ?>
                <a href="<?= ROOT_URL ?>/signin" class="btn">Log in</a>
                <a href="<?= ROOT_URL ?>/signup" class="btn">Create Account</a>
            <?php endif; ?>

            <?php if($session->is_logged_in()): ?>
                <div class="profile-picture">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture">
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Desktop Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="<?= ROOT_URL ?>" class="Tlogo">MyAgent</a>
            <ul class="nav-links">
                <li class="dropdown">
                    <a href="<?= ROOT_URL ?>/listings" class="dropdown-link">Listings</a>
                </li>
                <li><a href="<?= ROOT_URL ?>/about">About</a></li>
                
                <?php if($session->user('role')): ?>
                    <li><a href="<?= ROOT_URL ?>/dashboard/index">Dashboard</a></li>
                    <li><a href="<?= ROOT_URL ?>/logout">Logout</a></li>
                <?php else:?> 
                    <li><a href="<?= ROOT_URL ?>/signin" class="btn">Log in</a></li>
                    <li><a href="<?= ROOT_URL ?>/signup" class="btn">Create Account</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="auth-section">
            <?php if($session->is_logged_in()): ?>
                <div class="profile-picture">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture">
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>
