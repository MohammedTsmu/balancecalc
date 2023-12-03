<?php
$dateString = '2023-12-31'; // Example date string in YYYY-MM-DD format
$date = DateTime::createFromFormat('Y-m-d', $dateString);
$year = $date->format('Y'); // Output: 2023
?>

<footer class="container">
    <p>Made with love by &copy; Mohammed Q.Sattar (2021 - <?= $year ?>)</p>
</footer>
</body>

</html>