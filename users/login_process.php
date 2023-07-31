<?php
session_start();
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username       = $_POST['username'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];


    //Username
    if (isset($username) && !empty($username)) {
        if (!filter_var(trim($username), FILTER_SANITIZE_STRING)) {
            $_SESSION['username']   = $username . 'hello';
            $_SESSION['error_message'] = "Username Invalid this one";
            header("Location: login.php");
            exit();
        }
    }

    //Email Id
    if (isset($email) && !empty($email)) {
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "Please Enter Valid Email ID";
            header("Location: login.php");
            exit();
        }
    }

    //Password
    if (isset($password) && !empty($password)) {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/", $password) && !filter_var(trim($password), FILTER_SANITIZE_STRING)) {
            $_SESSION['error_message'] = "Password incorrect";
            header("Location: login.php");
            exit();
        }
    }

    // Validate and sanitize the input
    $username = mysqli_real_escape_string($mysqli, $username);
    $password = mysqli_real_escape_string($mysqli, $password);
    $email = mysqli_real_escape_string($mysqli, $email);
    // Prepare and execute the SQL query
    $stmt = $mysqli->prepare("SELECT id, email, password, user_role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $email, $hashed_password, $user_role);
    $stmt->fetch();
    $stmt->close();

    // Verify the password using password_verify() function
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $user_role;
        header("Location: user_profile.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid username/Password or User does not exist";
        header("Location: login.php");
        exit();
    }

    $mysqli->close();
}
