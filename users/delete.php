<?php
session_start();  
if(!isset($_SESSION["user_id"])){  
    header("location:login.php");  
} else { 
include('db.php');

if (isset($_GET["id"])) {
    // Get the ID from the URL
    $id = $_GET["id"];

    // Delete the user with the given ID from the 'users' table
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo  "User with ID $id was deleted successfully.";
    } else {
        echo  "Failed to delete user with ID $id.";
    }
    $stmt->close();
    $mysqli->close();

    // Redirect back to the main page after deletion
    //header("Location: user_list.php");
}
}
?>
