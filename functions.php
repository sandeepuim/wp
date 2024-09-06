<?php
/**Custom Login Script */ 
function custom_login_validation($user, $password) {
    if (empty($user->user_login)) {
        return new WP_Error('empty_username', 'Username cannot be empty.');
    }
    if (empty($password)) {
        return new WP_Error('empty_password', 'Password cannot be empty.');
    }

    return $user;
}
add_filter('wp_authenticate_user', 'custom_login_validation', 10, 2);
function custom_login_redirect( $redirect_to, $request, $user ) {
    // Ensure user is logged in before redirect
    if (is_wp_error($user)) {
        return home_url('/custom-login-page'); // Redirect back to custom login page if there's an error
    } else {
        return home_url(); // Redirect to homepage after successful login
    }
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

?>
