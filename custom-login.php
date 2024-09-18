<?php
/* Template Name: Login */

get_header();
$error_message='';
// Check if the form was submitted
if (isset($_POST['uname'], $_POST['pwd'])) {
    $username = sanitize_text_field( $_POST['uname'] );
    $password = $_POST['pwd'];
    $user = wp_authenticate( $username, $password );

    if ( is_wp_error( $user ) ) {
       
         $error_code = $user->get_error_code();

        if ( $error_code === 'invalid_username' || $error_code=='invalid_email' ) {
            $error_message = 'Invalid username or email. Please try again.';
        } elseif ( $error_code === 'incorrect_password' ) {
            $error_message = 'Incorrect password. Please try again.';
        } else {
            $error_message = 'An unknown error occurred. Please try again.';
        }
    } else {
        // If authentication is successful, log the user in and redirect
        wp_set_current_user( $user->ID );
        wp_set_auth_cookie( $user->ID );
        wp_redirect( home_url() );
        exit;
    }
}
if ( is_user_logged_in() ) {
        wp_redirect( home_url() );
        exit;
    }

?><main class="main">
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>
           
       <?php if(isset($error_message)){ ?>
            <div style="color:red;"><?php echo $error_message; ?></div>
            <?php } ?>

    <form method="post" action="" class="custom-login-form">
      
         <div class="form-group">
                        <label for="fame">Username or Email Address</label>
                        <input type="text" class="form-control" name="uname" id="username" value="" required>

                    </div>
                    <div class="form-group">
                        <label for="lame">Password</label>
                        <input type="password" name="pwd" id="password" class="form-control"   value="" required>

                    </div>
        <p>
            <input type="submit" name="wp-submit" class="btn btn-primary btn-block mt-3" value="Login">
            <input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>">
        </p>
    </form>

    
 </div>
        </div>
    </div>

    


</main>

<?php get_footer(); ?>

