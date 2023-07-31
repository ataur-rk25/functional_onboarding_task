<?php
// Display success or error messages if they are set in the session
session_start();
$title = 'Register';
include('header.php');
?>
<div class="container">
    <div class="row">
        <h2 class="pagetitle">Registration</h2>
    </div>
    <div class="row d-flex">
        <div class="flex-50">
            <?php if (isset($_SESSION['user_id']) != "") {
                echo '<h3>You are already regsitered</h3>';
                echo '<a href="user_profile.php"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</a>&nbsp;&nbsp;&nbsp;';
                echo '<a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a>';
            } else {


                if (isset($_SESSION['success_message'])) {
                    echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                    unset($_SESSION['success_message']); // Clear the success message after displaying
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']); // Clear the error message after displaying
                }
            ?>
                <form action="register_process.php" method="post" id="register_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <div class="form-group-row d-flex">
                        <div class="form-group flex-50">
                            <input class="form_input" type="text" name="username" id="username" placeholder="Username*">
                            <p class="error_message" id="username_error" style="color: red;"></p>
                        </div>
                        <div class="form-group flex-50">
                            <input class="form_input" type="text" name="name" id="name" placeholder="Name*">
                            <p class="error_message" id="name_error" style="color: red;"></p>
                        </div>
                    </div>
                    <div class="form-group-row d-flex">
                        <div class="form-group flex-50">
                            <input class="form_input" type="email" name="email" id="email" placeholder="Email*">
                            <p class="error_message" id="email_error" style="color: red;"></p>
                        </div>
                        <div class="form-group flex-50">
                            <input class="form_input" type="tel" name="phone" id="phone" placeholder="Phone" maxlength="20">
                            <p class="error_message" id="phone_error" style="color: red;"></p>
                        </div>
                    </div>
                    <div class="form-group-row d-flex">
                        <div class="form-group flex-50">
                            <div class="password-wrapper">
                                <input class="form_input" type="password" name="password" id="password" placeholder="Password*">
                                <i class="fa fa-eye input_icons" id="eye-icon"></i>
                            </div>
                            <small>Password must be 6 chars long and have at least 1 Capital letter, 1 number, 1 special chars from !@#$%()</small>
                            <p class="error_message" id="password_error" style="color: red;"></p>
                        </div>
                        <div class="form-group flex-50">
                            <input class="form_input" type="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password*">
                            <p class="error_message" id="confirm_password_error" style="color: red;"></p>
                        </div>
                    </div>
                    <div class="form-group-row d-flex">
                        <div class="form-group flex-50">
                            <div class="file-upload-container">
                                <label for="profile_pic_input" class="file-upload-label" id="profile-file-name">Choose Profile Picture</label>
                                <input class="form_input" type="file" id="profile_pic_input" name="profile_pic_input" accept="image/*">
                                <i class="fa fa-upload input_icons"></i>
                            </div>
                            <div id="profile-file-name-error">No file selected</div>
                            <p class="error_message" id="profile_img_error" style="color: red;"></p>
                            <div id="profile_preview_wrapper">
                                <span class="profile-remove-icon"><i id="removeImagePreview" class="fa fa-close"></i></span>
                                <div id="profile_pic" class="profile_pic">
                                    <img id="profile_preview" class="profile_preview" src="#" alt="Profile Preview" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group flex-50">

                        </div>
                    </div>
                    <div class="form-group-row">
                        <div class="form-group">
                            <input type="submit" value="Register" class="form-btn">
                        </div>
                    </div>
                    <p class="error_message" id="form_submit_error" style="color: red;"></p>
                </form>
                <br>
                <div class="form-group-row">
                    <div class="form-group">
                        <p>Already have an account? <a href="login.php" class="form-btn">Login Now</a></p>
                    </div>
                </div>
        </div>
        <div class="flex-50">
            <div class="img-wrapper text-center">
                <img src="assets/img/register_img.jpg" width="100%" height="auto" class="register-img" />
            </div>
        </div>
    <?php } ?>
    </div>
    <?php
    include('footer.php');
    ?>