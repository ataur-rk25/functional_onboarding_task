<?php
$title = 'Forgot Password';
include('header.php');
?>
<div class="container">
    <div class="row">
        <h2 class="pagetitle">Forgot Password</h2>
    </div>
    <div class="row">
        <form action="login_process.php" method="post" style="max-width:500px;margin:auto">
            <div class="form-group-row">
                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username/Email" required>
                </div>
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <input type="submit" value="Reset Password" class="form-btn">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include('footer.php');
?>