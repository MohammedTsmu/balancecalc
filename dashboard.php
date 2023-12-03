<?php
$title = "Transaction Dashboard";
include('header.php');

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "balancecalc";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['search_date'])) {
    $search_date = $_POST['search_date'];
    $query = "SELECT * FROM transactions WHERE DATE(transaction_date) = '$search_date'";
} else {
    $query = "SELECT DATE(transaction_date) AS date, COUNT(*) AS transactions_count FROM transactions GROUP BY DATE(transaction_date)";
}

$result = mysqli_query($conn, $query);

?>

<div class="container">
    <div class="sub-container">
        <h1><?php echo $title; ?></h1>
        <?php include('nav.php'); ?>

        <form method="post">
            <label for="search_date">Search by Date:</label>
            <input type="date" id="search_date" name="search_date">
            <button type="submit">Search</button>
        </form>
    </div>


    <div class="sub-container">
        <div class="result-table">
            <?php
            if (isset($_POST['search_date'])) {
                echo "<h2>Transactions by Date " . $_POST['search_date'] . " </h2>";
            }


            if (isset($_POST['delete_group'])) {
                $delete_date = $_POST['delete_date'];

                $delete_query = "DELETE FROM transactions WHERE transaction_datetime = '$delete_date'";
                $delete_result = mysqli_query($conn, $delete_query);

                if ($delete_result) {
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Error deleting transactions: " . mysqli_error($conn);
                }
            }


            if (isset($_POST['search_date'])) {
                if (mysqli_num_rows($result) > 0) {
                    $transactions = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $transactions[] = $row;
                    }

                    $groupedTransactions = [];
                    foreach ($transactions as $transaction) {
                        $groupedTransactions[$transaction['transaction_datetime']][] = $transaction;
                    }

                    $counter = 0;
                    $finalCounter = count($groupedTransactions);

                    echo "<h2>$finalCounter Transactions</h2>";

                    foreach ($groupedTransactions as $datetime => $transactions) {
                        if (!empty($transactions)) {
                            $counter++;
                            echo "<div class='result-table'>";
                            echo "<form method='post'>";
                            echo "<h2><code>$counter| Transactions on $datetime</code></h2>";
                            echo "<input type='hidden' name='delete_date' value='$datetime'>";
                            echo "<button type='submit' name='delete_group'>Delete Group</button>";
                            echo "</form>";
                            echo "<table>";
                            echo "<thead><tr><th>#</th><th>Transaction Date</th><th>Transaction Details</th><th>Type</th><th>Quantity</th><th>Total Price</th></tr></thead>";
                            echo "<tbody>";

                            $count = 1;
                            $totalGroupPrice = 0;

                            foreach ($transactions as $transaction) {
                                echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $transaction['transaction_datetime'] . "</td>";
                                echo "<td>" . $transaction['type'] . "</td>";
                                echo "<td>" . $transaction['category'] . "</td>";
                                echo "<td>" . $transaction['quantity'] . "</td>";
                                echo "<td>" . $transaction['total_price'] . "</td>";
                                echo "</tr>";

                                $totalGroupPrice += $transaction['total_price'];
                            }

                            echo "<tr><td colspan='5'><strong>Total Group Price</strong></td><td><strong>$totalGroupPrice</strong></td></tr>";

                            echo "</tbody></table>";
                            echo "</div>";
                        }
                    }
                } else {
                    echo "<p>No transactions found for the selected date.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>