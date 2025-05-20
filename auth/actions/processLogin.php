<?php
session_start();
require "../../config/dbConn.php";
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM admins WHERE email = ? and password = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = is_countable($row);
if ($count > 0) {
    $_SESSION['email'] = $row['email'];
    $_SESSION['alert'] = ['type'=> 'success', 'message' => 'Login successful']; 
    header('location: ../../index.php');
} else {
    $_SESSION['msg'] = "Invalid Email and password";
    header('location: ../login.php');
}

?>