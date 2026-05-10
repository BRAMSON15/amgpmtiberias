<?php
require_once 'config/database.php';

// Add role column to users table
$sql1 = "ALTER TABLE users ADD role VARCHAR(20) DEFAULT 'admin'";
mysqli_query($conn, $sql1);

// Update existing admin to have role admin
$sql2 = "UPDATE users SET role='admin' WHERE username='admin'";
mysqli_query($conn, $sql2);

// Make sure the user doesn't already exist, then insert
$sql3 = "SELECT * FROM users WHERE username='user'";
$result = mysqli_query($conn, $sql3);

if (mysqli_num_rows($result) == 0) {
    $sql4 = "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('user', MD5('user'), 'Guest User', 'user')";
    if (mysqli_query($conn, $sql4)) {
        echo "SUCCESS: User 'user' added with role 'user'.";
    } else {
        echo "ERROR insert: " . mysqli_error($conn);
    }
} else {
    echo "User 'user' already exists.";
}
?>
