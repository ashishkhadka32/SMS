<?php
require "../../config/dbConn.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Check if email already exists
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "This email already exists";
    } else {
        // Insert new user
        $sql = "INSERT INTO admins(name, email, password) VALUES(?, ?, ?)";
        $stmt = $connection->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $connection->error);
        }

        $stmt->bind_param("sss", $name, $email, $password);
        $res = $stmt->execute();

        if ($res) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Registration successful'];
            header("Location: ../login.php");
            exit;
        } else {
            echo "Insert failed: " . $stmt->error;
        }
    }
} else {
    echo "Form not submitted properly.";
}
?>
