<?php
include('db.php');
// Create the 'users' table if it doesn't exist
$create_table_query = "CREATE TABLE IF NOT EXISTS users (    
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) ,
    email VARCHAR(255) NOT NULL,
    user_role VARCHAR(255) NOT NULL,
    profile_pic_path TEXT
)";

if ($mysqli->query($create_table_query) === false) {
    die("Error creating table: " . $mysqli->error);
} else {
    $username = 'admin';
    $name = 'Admin';
    $admin_password = password_hash('Admin123!', PASSWORD_DEFAULT);
    $phone = '';
    $email = 'admin@email.com';
    $user_role = 'admin';

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        //do nothing
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (username, password, name, phone, email, user_role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $admin_password, $name, $phone, $email, $user_role);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['setup_completed'] = true;
    header("Location: login.php");
    exit();
}
