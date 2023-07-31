<?php
session_start();

if (!isset($_SESSION["user_id"])) {
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
            $_SESSION['success_message'] = "Deleted Successfully";
            header("Location: user_list.php");
        } else {
            $_SESSION['error_message'] =  "Error: " . $stmt->error;
            header("Location: user_list.php");
        }

        $stmt->close();
        $mysqli->close();
    }
}
