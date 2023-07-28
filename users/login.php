<?php
    session_start();
    if(isset($_SESSION['user_id']) != "") {
        header("Location: user_profile.php");
    }
  $title = 'Login';
  include('header.php');
?>
<div class="container">
    <div class="row">
        <h2 class="pagetitle">Login</h2>
    </div>
    <div class="row d-flex">
	    <div class="flex-50">
        <?php
            // Display success or error messages if they are set in the session
            if (isset($_SESSION['username'])) {    
            echo $_SESSION['username'];
        }
                if (isset($_SESSION['success_message'])) {
                    echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                    unset($_SESSION['success_message']); // Clear the success message after displaying
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']); // Clear the error message after displaying
                }
            ?>
            <form action="login_process.php" method="post">
                <div class="form-group-row">        
                    <div class="form-group">
                        <input type="text" name="username" id="username" placeholder="Username"> 
                        <p class="text-center">OR</p>
                        <input type="email" name="email" id="email" placeholder="Email" pattern="/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%()]).{6,}$/">
                    </div>
                </div>
                <div class="form-group-row">
	                <div class="form-group">
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" placeholder="Password*"  required>
                            <i class="fa fa-eye input_icons" id="eye-icon"></i>
	                    </div>
		            </div>
    	        </div>
                <!--<div class="form-group-row">
	                <div class="form-group d-flex">
                        <input type="checkbox" name="remember_me" id="remember_me"><label for="remember_me">Remember me</label>
                    </div>
                </div>-->
                <div class="form-group-row">
                    <div class="form-group">
	                    <input type="submit" value="Login" class="form-btn">
                    </div>
                </div>
            </form>
            <div class="form-group-row">
                <div class="form-group">
                    <br>
                    <!--<p><a href="forgot_password.php">Forgot Password?</a></p><br>-->
                    <p>You don't have account?  <a href="register.php" class="form-btn">Register Now</a></p>
                </div>
            </div>
        </div>
        <div class="flex-50">
	        <div class="img-wrapper text-center">
			    <img src="assets/img/login_img.jpg" width="100%" height="auto" class="register-img"/>
		    </div>
	    </div>
    </div>
</div>
<?php
  include('footer.php');
?>