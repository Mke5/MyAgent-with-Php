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
    <title>User Sign In</title>
    <link rel="stylesheet" href="<?= ASSETS ?>css/s.css">
</head>
<body id="page-content">
    <?php include_once "includes/loader.php";?>
    <div class="auth-container">
        <div class="auth-form">
            <h2>Sign In</h2>
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
            <br>
            <form action="<?= ROOT_URL ?>/signin/authenticate" method="post">
                <input type="hidden" name="csrf_token" value="<?= $session->csrf_token(); ?>">

                <div class="formItem">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= $session->get('last_email')?>" placeholder="Email" required>
                </div>
                <div class="formItem">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Password" id="password" required autocomplete="off">
                    <div id="see">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                            <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                        </svg>
                    </div> 
                </div>
                <button type="submit" name="submit" class="btn" id="btn-submit">
                    <span class="button--text">Login</span>

                    <div class="button--loader">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </button>
                <script>
                    const submitButton = document.getElementById('btn-submit');
                    const submitButtonText = document.querySelector('#btn-submit .button--text');

                    submitButton.addEventListener('click', (e)=> {
                        // add loading class
                        submitButton.classList.add('loading');
                        setTimeout(() => {
                            submitButton.classList.remove('loading');
                            submitButton.classList.add('success');

                            // change the button text
                        }, 4000)
                    })
                </script>
            </form>
            <p><small>Don't have an account? <a href="<?= ROOT_URL?>/signup">Signup</a></small></p>
        </div>
    </div>
    
    <script src="<?=ASSETS?>/js/see.js"></script>

</body>
</html>
