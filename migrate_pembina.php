<?php
require_once 'config/database.php';

$sql = "ALTER TABLE pembina ADD foto VARCHAR(255) DEFAULT NULL";
if (mysqli_query($conn, $sql)) {
    echo "SUCCESS: Column 'foto' added successfully.";
} else {
    echo "ERROR: " . mysqli_error($conn);
}
?>
