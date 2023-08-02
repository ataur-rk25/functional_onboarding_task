<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location:login.php");
} else {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        $title = 'Users List';
        include('header.php');
?>
        <div class="container">
            <div class="row">
                <h2 class="pagetitle">Users List</h2>
                <p style="text-align:right">
                    <a href="user_profile.php"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</a>&nbsp;&nbsp;&nbsp;
                    <a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a>
                </p>
            </div>
            <div class="row">
                <div style="text-align:right">
                    <a href="#" id="add" class="form-btn">Add</a>
                </div>
                <br>
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                    unset($_SESSION['success_message']);
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <div id="users_list"></div>
            </div>
        </div>

        <?php
        include('footer.php');
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                loadUserTable();
            });
        </script>
<?php
    } else {
        header("Location: user_profile.php");
        exit();
    }
}
