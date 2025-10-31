<?php
session_start();
include "../includes/db.php";

if (isset($_POST["username"], $_POST["email"], $_POST["password"], $_POST["role"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"]; 

    $check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../auth/auth.php?error=user_exists");
        exit();
    }

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashPassword, $role);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: ../pages/admin/dashboard.php");
        } else {
            header("Location: ../pages/index.php");
        }
        exit();
    } else {
        header("Location: ../auth/auth.php?error=signup_failed");
        exit();
    }
} else {
    header("Location: ../auth/auth.php?error=missing_fields");
    exit();
}
