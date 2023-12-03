<?php
$title = "Add item";
include('header.php');
?>

<!-- Main Container -->
<div class="container">
    <?php
    echo "<div class ='sub-container'>";
    echo "<h1>{$title}</h1>";
    include('nav.php');
    echo "</div>";

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

    if ($conn) {
        // echo "Connected to the database";
        echo "";
    }

    ?>


    <!-- Add Form -->
    <form action="add.php" method="post">
        <!-- Form Container -->
        <div class="sub-container grid2">
            <!-- Cards -->
            <div class="card">
                <label for="type">Type</label>
                <br>
                <input type="text" name="type" id="type" placeholder="Zain, Asia, Korek">

                <br>
                <br>
                <label for="type">Category</label>
                <br>
                <input type="category" name="category" id="category" placeholder="2, 5, 10, 15, 25, 35....">

                <br>
                <br>
                <label for="price">Price</label>
                <br>
                <input type="price" name="price" id="price" placeholder="10.500 / 5.250 / 16.00.....">
            </div>
            <input type="submit" name="submit" value="Add Card">
        </div>
        <!-- End Form Container-->

    </form>
    <!-- End Form -->

    <?php
    if (isset($_POST['submit'])) {
        if (!empty($_POST['type']) && !empty($_POST['category'])) {
            // if (empty($_POST['type']) && empty($_POST['category'])) {

            $type = $_POST['type'];
            $category = (int) $_POST['category'];
            $price = (float)$_POST['price'];

            $sql = "INSERT INTO balances(type, category, price) values('$type','$category', '$price')";

            try {
                mysqli_query($conn, $sql);
                echo "<div class = 'pass'>({$type} {$category} {$price}) Card inserted successfully</div>";
            } catch (mysqli_sql_exception) {
                echo "<div class = 'fail'>({$type} {$category} {$price}) card Failed, error 404!</div>";
            }
        } else {
            echo "<div class = 'fail'>Form Must Have Card Details, (Empty Values error 404!) </div>";
        }
    }

    mysqli_close($conn);
    ?>

</div>
<!-- End Main Container-->

<?php
include('footer.php');
?>