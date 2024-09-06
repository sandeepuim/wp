<?php
/*
Template Name: Custom Login
*/

global $user_login;
$error = '';

// If the form is submitted
if (isset($_POST['log']) && isset($_POST['pwd'])) {
    $credentials = array(
        'user_login'    => sanitize_text_field($_POST['log']),
        'user_password' => sanitize_text_field($_POST['pwd']),
        'remember'      => isset($_POST['rememberme']) ? true : false,
    );

    // Attempt to sign the user in
    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        // If login failed, capture error
        $error = $user->get_error_message();
    } else {
        // Redirection logic
        $redirect_url = home_url();
        wp_safe_redirect($redirect_url);
        exit; // Stop further execution after redirection
    }
}
get_header();
?>
<style>
.custom-login-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 10px;
}
.custom-login-form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}
.custom-login-form input[type="text"],
.custom-login-form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.custom-login-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #0073aa;
    color: white;
    border: none;
    border-radius: 5px;
}


</style>
<div class="custom-login-form">
    <?php if (!empty($error)): ?>
        <div class="login-error" style="color: red;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <label for="username">Username or Email Address</label>
        <input type="text" name="log" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="pwd" id="password" required>

        <label for="rememberme">Remember Me</label>
        <input type="checkbox" name="rememberme" id="rememberme" value="forever">

        <input type="submit" name="wp-submit" value="Log In">

        <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>"> <!-- Redirection URL -->

        <?php wp_nonce_field('login', 'login_nonce'); ?>
    </form>
</div>

<?php get_footer(); ?>
