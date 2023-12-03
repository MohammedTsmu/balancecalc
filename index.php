<?php
$title = "Calculate Balances";
include('header.php');

// Establish database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "balancecalc";
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception) {
    echo "Could not Connect to the database";
}

?>

<div class="container">
    <div class="sub-container">
        <h1><?php echo $title; ?></h1>
        <?php include('nav.php'); ?>
    </div>

    <form action="index.php" method="post">
        <div class='grid2'>
            <div class='grid2'>
                <?php
                $sql = "SELECT * FROM balances";
                $result = mysqli_query($conn, $sql);
                $counter = 0;

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="client-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Client Quantity</th>
                                <th>Edit Price</th> <!-- New column for Edit Price -->
                                <th>Delete Item</th> <!-- New column for Delete Item -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $counter++;
                            ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><input type="number" name="clientQuantity[<?php echo $row['id']; ?>]" placeholder="1, 3, 7, 25, 50..." value=""></td>
                                    <td><a href="edit_price.php?id=<?php echo $row['id']; ?>">Edit</a></td> <!-- Link to Edit Price page -->
                                    <!-- Delete button -->
                                    <td>
                                        <form action="delete_entry.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <a href="">
                                                <button type="submit" id="deleteBtn" name="delete">Delete</button>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="reset" value="Reset Quantities" class="dark-lightred">
            </div>
            <!-- <input type="submit" name="calculatePrices" value="Calculate Prices" class="dark-lightgreen"> -->
            <input type="submit" name="calculatePrices" value="Calculate Prices" class="dark-lightgreen">
        <?php
                } else {
                    echo "<div class='sub-container fail'>No cards recorded yet.</div>";
                }
        ?>
        </div>
    </form>




    <!-- Demo -->
    <!-- Demo -->
    <!-- Demo -->
    <?php
    if (isset($_POST['calculatePrices'])) {
        if (isset($_POST['clientQuantity'])) {
            // Your existing code to display entered client quantities
    ?>
            <div class="result-table">
                <h2>Entered Client Quantities</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Client Quantity</th>
                            <th>Card Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $summary = 0;
                        foreach ($_POST['clientQuantity'] as $id => $quantity) {

                            // Fetch the corresponding type and category using $id from the POST data
                            $sql = "SELECT type, category, price FROM balances WHERE id = $id";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            // $summary += $quantity * $row['price'];
                            // Convert $quantity and $row['price'] to numeric values
                            $quantity = (float)$quantity;
                            $price = (float)$row['price'];

                            $totalPrice = $quantity * $price;
                            $summary += $totalPrice;
                        ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $quantity * $row['price']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Summary Table -->
                <table>
                    <thead>
                        <tr>
                            <!-- <th>Summary</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo "<h3>Summary</h3>"; ?></td>
                            <td><?php /*echo "<h3>" . number_format($summary, 2) . " IQD</h3>";*/ ?></td>
                            <td><?php echo "<h3>" . number_format($summary, 3) . " IQD</h3>";
                                ?></td>
                            <td colspan='5'><?php #echo "<h3>" . $summary . " IQD</h3>"; 
                                            ?></td>

                        </tr>
                    <tbody>
                </table>
            </div>
    <?php
            // Inserting transaction details into a new table
            foreach ($_POST['clientQuantity'] as $id => $quantity) {
                $sql = "SELECT type, category, price FROM balances WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                // Calculate total price for each item
                $quantity = (float)$quantity;
                $price = (float)$row['price'];
                $totalPrice = $quantity * $price;

                // Insert into a new transactions table
                $insertSql = "INSERT INTO transactions (type, category, quantity, total_price, transaction_date, transaction_datetime)
    VALUES ('{$row['type']}', '{$row['category']}', $quantity, $totalPrice, NOW(), NOW())";
                mysqli_query($conn, $insertSql);
            }
        }
    }
    mysqli_close($conn);
    ?>

</div>

<?php include('footer.php'); ?>