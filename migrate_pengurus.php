<?php
require_once 'config/database.php';

$sql = "ALTER TABLE pengurus ADD foto VARCHAR(255) DEFAULT NULL";
if (mysqli_query($conn, $sql)) {
    echo "SUCCESS: Column 'foto' added successfully.";
} else {
    // If it already exists, it might throw an error, which is fine
    echo "ERROR: " . mysqli_error($conn);
}
?>
