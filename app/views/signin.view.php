<?php
    
    $session = new Core\Session;

    if ($session->user()) {
        redirect('home');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin - MyAgent</title>
    <link rel="stylesheet" href="<?=ASSETS?>css/s.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">

            <div class="showcase-content">
                <h2>Find Your<br>Dream Home</h2>
                <p>Discover exclusive properties tailored to your lifestyle with personalized search and expert guidance from various agents around you.</p>
            </div>
        </div>

        <!-- Right Section - Onboarding Form -->
        <div class="right-section">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2zm0 2.8L18 10v9h-2v-6H8v6H6v-9l6-7.2z"/>
                        </svg>
                    </div>
                    <span class="logo-text">MyAgent</span>
                </div>
            </div>

            <div class="form-container">
                <div class="welcome-message">
                    <h1>Hi! Welcome back to<br>MyAgent 👋</h1>
                    <small>Sign in to continue</small>
                    <p>
                        <small style="color: rgb(0, 100, 0);">
                            <?php
                                if ($message = $session->pop('signin-s')) {
                                    echo $message;
                                }
                            ?>
                        </small>
                        <small style="color: rgb(211, 8, 8);">
                                <?php
                                    if($message = $session->pop('signin')) {
                                        echo $message;
                                    }
                                ?>
                        </small>
                    </p>
                </div>

                

                <form class="onboarding-form" method="Post" action="<?= ROOT_URL ?>/signin/authenticate">
                    <input type="hidden" name="csrf_token" value="<?= $session->csrf_token(); ?>">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"  placeholder="mike@example.com" value="<?= $session->get('last_email')?>" required>
                    </div>

                    <div class="form-group password-group">
                        <label for="password">Password</label>
                        <div class="password-input">
                            <input type="password" class="password" id="password" placeholder="••••••••" required name="password">
                            <button type="button" class="toggle-password">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#A0A0A0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#A0A0A0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="submit-btn">Sign In</button>

                    <div class="login-link">
                        <span>Already have an account?</span>
                        <a href="<?= ROOT_URL ?>/signup">Sign up
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?=ASSETS?>/js/s.js"></script>
</body>
</html>
