<?php
include('db.php');

$stmt = $mysqli->prepare("SELECT* FROM users");
$stmt->execute();
$result = $stmt->get_result();
$usersList = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$mysqli->close();


if ($usersList) :
  header('Content-Type: application/json');
  echo json_encode($usersList);
endif;
