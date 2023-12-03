<?php
$title = "Edit Price";
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

// Check if 'id' is present in the URL query parameters
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve item details based on the 'id'
    $sql = "SELECT * FROM balances WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // If item found
    if ($row) {
        // Handle form submission to update the price
        if (isset($_POST['updatePrice'])) {
            $newPrice = $_POST['newPrice'];
            $newType = $_POST['newType'];
            $newCategory = $_POST['newCategory'];

            // Update the price in the database
            // $updateSql = "UPDATE balances SET price = $newPrice WHERE id = $id";










            // Prepare the SQL statement
            $updateSql = "UPDATE balances 
              SET price = ?, 
                  type = ?, 
                  category = ? 
              WHERE id = ?";

            // Create a prepared statement
            $stmt = mysqli_prepare($conn, $updateSql);

            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, "dssi", $newPrice, $newType, $newCategory, $id);
            mysqli_stmt_execute($stmt);

            // Check for successful execution or handle errors
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Updated successfully
                header("Location:index.php");
                die();
            } else {
                // Failed to update or no rows affected
            }









            // $updateSql = "UPDATE balances SET price = $newPrice, type=$newType, category= $newCategory WHERE id = $id";
            // if (mysqli_query($conn, $updateSql)) {
            //     echo "Price updated successfully.";
            //     header("Location:index.php");
            //     die();
            // } else {
            //     echo "Error updating price: " . mysqli_error($conn);
            // }
        }
?>
        <!-- HTML form to update the price -->
        <div class="container">
            <h1><?php echo $title; ?></h1>
            <form action="" method="post">
                <label for="newPrice">New Price:</label>
                <input type="number" name="newPrice" id="newPrice" value="<?php echo $row['price']; ?>" required><br />


                <label for="newType">New Type:</label>
                <input type="text" name="newType" id="newType" value="<?php echo $row['type']; ?>" required><br />

                <label for="newCategory">New Category:</label>
                <input type="number" name="newCategory" id="newCategory" value="<?php echo $row['category']; ?>" required>


                <input type="submit" name="updatePrice" value="Update Price">
            </form>
        </div>
<?php
    } else {
        echo "Item not found.";
    }
} else {
    echo "No item ID provided.";
}

mysqli_close($conn);
include('footer.php');
?>