<?php
/* Template Name: Registration */

get_header();

$successmsg = '';
$errormsg = '';
if (isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'])) {
    $fname = sanitize_text_field($_POST['fname']);
    $lname = sanitize_text_field($_POST['lname']);

    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $phoneno = $_POST['phoneno'];

    // Check if email already exists
    if (email_exists($email)) {
        $errormsg = "Email id is already exist.";
    } else {
        // Create user
        $user_id = wp_create_user($email, $password, $email);
        if (!is_wp_error($user_id)) {
            wp_update_user([
                'ID' => $user_id,
                'display_name' => $fname . ' ' . $lname,
            ]);
            update_user_meta($user_id, 'phoneno', $phoneno);
            update_user_meta($user_id, 'first_name', $fname);
            update_user_meta($user_id, 'last_name', $lname);

            $successmsg = "Registration successful! ";
             $successmsg = "Registration successful! ";
            $body='<div >Thank you for registering! Your account has been created successfully.</div>';
            $sub='Welcome to the Wordpress Family!';
            custom_mail($email,$fname.' '.$lname,$sub,$body);
        } else {
            $errormsg = "Something went wrong, Please try again";
        }
    }
}
?>
<main class="main">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Register</h2>
  <?php if(isset($successmsg)){ ?>
            <div style="color:green;"><?php echo $successmsg; ?></div>
            <?php } ?>
            <?php if(isset($errormsg)){ ?>
            <div style="color:red;"><?php echo $errormsg; ?></div>
            <?php } ?>

                
                <form id="custom_registration_form" action="" method="POST" >

                    <div class="form-group">
                        <label for="fame">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname"  value="" required>

                    </div>
                    <div class="form-group">
                        <label for="lame">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname"  value="" required>

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required autocomplete="off">

                    </div>
                    <div class="form-group">
                        <label for="phoneno">Phone No</label>
                        <input type="text" class="form-control" name="phoneno" id="phoneno" required autocomplete="off">

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>

                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-5">Register</button>
                </form>
            </div>
        </div>
    </div>


</main>

<?php get_footer(); ?>

