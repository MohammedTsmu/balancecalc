<?php
$title = "Calculate Balances";
include('header.php');

// Establish database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "demo";
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception) {
    echo "Could not Connect to the database";
}



// Ensure your database connection is established

// Check if the 'delete' button is clicked and 'id' is set
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the SQL DELETE query
    $deleteSql = "DELETE FROM balances WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteSql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Check if deletion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Entry deleted successfully.";
            header("Location: index.php");
        } else {
            echo "Failed to delete entry.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error in prepared statement.";
    }
}

// Close your database connection
mysqli_close($conn);
