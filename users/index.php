<?php
session_start();
if (!isset($_SESSION['setup_completed'])) {
    include('setup.php');
} else {
    if (isset($_SESSION['user_id']) != "") {
        header("Location: user_profile.php");
    }
    header("Location: login.php");
    exit();
}
