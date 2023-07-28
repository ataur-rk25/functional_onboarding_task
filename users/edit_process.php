<?php
include('db.php');
session_start(); 

if (isset($_SERVER['HTTP_REFERER'])) {
    $headerLocation = header("Location: " . $_SERVER['HTTP_REFERER']);
    
} else {
    $headerLocation = header("Location: user_profile.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username           = $_POST['username'];
    $name               = $_POST['name'];
    $password           = $_POST['password'];
    $confirm_password   = $_POST['confirm_password'];
    $email              = $_POST['email'];
    $phone              = $_POST['phone'];
    $uid                = $_POST['user_id'];
    $profile_pic        = $_FILES['profile_pic_input'];
    
    if(isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin'){
        $user_role  =   $_POST['user_role'];
    }
    //Username
    if(isset($username) && !empty($username)){
    if (!filter_var(trim($username), FILTER_SANITIZE_STRING)) {
        $_SESSION['error_message'] = "Username Invalid";
        $headerLocation;
        exit();
    }
    }
    //Name
    if(isset($name) && !empty($name)){
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $_SESSION['error_message'] = "Name must contain only alphabets and space";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }        
    }
    
    //Password
    if(isset($password) && !empty($password)){
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%()]).{6,}$/",$password)) {
            $_SESSION['error_message'] = "password not match criteria";
            $headerLocation;
            exit();
        }
        if ($password !== $_POST['confirm_password']) {
            $_SESSION['error_message'] = "Passwords do not match.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }        
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    //Email Id
    if(isset($email) && !empty($email)){
    if(!filter_var(trim($email),FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Please Enter Valid Email ID";
        $headerLocation;
        exit();
    }
    }
    //Phone
    if(isset($phone) && !empty($phone)){
    if(!filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT)) {
        $_SESSION['error_message'] = "Invalid Phone";
        exit();
    }
    }
    if(isset($user_role) && !empty($user_role)){
        if (!filter_var(trim($user_role), FILTER_SANITIZE_STRING)) {
            $_SESSION['error_message'] = "Role Invalid";
            $headerLocation;
            exit();
        }
    }
    
    if (isset($profile_pic) && $profile_pic["error"] === UPLOAD_ERR_OK) {
    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($profile_pic['type'], $allowedTypes)) {
        $_SESSION['error_message'] = 'Invalid file type. Only JPEG, PNG, and GIF images are allowed.';    
        $headerLocation;
        exit();
    }
    $maxSizeInBytes = 2 * 1024 * 1024;
    if ($profile_pic['size'] > $maxSizeInBytes) {
        $_SESSION['error_message'] = 'File size exceeds the limit of 2 MB.';    
        $headerLocation;
        exit();
    }

    //store pic
    $originalFileName = $profile_pic['name'];
    $fileName = basename($originalFileName);
    $targetDir = 'profile_pics/';
    $targetFilePath = $targetDir . $fileName;

    if (!move_uploaded_file($profile_pic['tmp_name'], $targetFilePath)) {
        $_SESSION['error_message'] = 'Failed to move uploaded file to destination.';    
        $headerLocation;
        exit();
    }
    }
    else{
        
    }
    // Validate and sanitize the input
    //$username = mysqli_real_escape_string($mysqli, $username);
    $name = mysqli_real_escape_string($mysqli, $name);
    $phone = mysqli_real_escape_string($mysqli, $phone);
    $email = mysqli_real_escape_string($mysqli, $email);
    $user_role = mysqli_real_escape_string($mysqli, $user_role);

        // Prepare and execute the SQL query to check if the user already exists
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? ";
        $parameterTypes = "sss";
        $parameters = array($name, $email, $phone);

        if (!empty($user_role)) {
           
            $sql .= ", user_role = ?";
            $parameterTypes .= "s";
            $parameters[] = $user_role;
        }

        if (!empty($password)) {
            
            $sql .= ", password = ?";
            $parameterTypes .= "s";
            $parameters[] = $hashed_password;
        }

        if ($profile_pic["error"]=== UPLOAD_ERR_OK) {
            $sql .= ", profile_pic_path = ?";
            $parameterTypes .= "s";
            $parameters[] = $targetFilePath;
        }

        $sql .= " WHERE id = ?";
        $parameterTypes .= "i";
        $parameters[] = $uid;

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param($parameterTypes, ...$parameters);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Updated Successfully";
            $headerLocation;
            exit();
        } else {
            $_SESSION['error_message'] =  "Error: " . $stmt->error;
            $headerLocation;
            exit();
        }
        $stmt->close();        
        $mysqli->close();
}
?>
