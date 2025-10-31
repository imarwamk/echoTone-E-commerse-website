<?php
session_start();
include "../includes/db.php";

if (isset($_POST["username"], $_POST["password"], $_POST["role"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            if ($user['role'] !== $role) {
                header("Location: ../auth/auth.php?error=wrong_role");
                exit();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../pages/admin/dashboard.php");
            } else {
                header("Location: ../pages/index.php");
            }
            exit();

        } else {
            header("Location: ../auth/auth.php?error=wrong_password");
            exit();
        }
    } else {
        header("Location: ../auth/auth.php?error=user_not_found");
        exit();
    }
} else {
    header("Location: ../auth/auth.php?error=missing_fields");
    exit();
}

