<?php
// Include the database connection
include 'db.php';

// Handle search input
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination setup
$items_per_page = 6; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Query to fetch data from PX_ITEMS table with pagination and search
$sql = "SELECT * FROM PX_ITEMS WHERE ITEM_CODE LIKE ? OR ITEM_PROD_DESC LIKE ? ORDER BY ITEM_CODE OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params = ["%$search_query%", "%$search_query%", $offset, $items_per_page];
$stmt = sqlsrv_query($conn, $sql, $params);

// Check if query execution was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Query to get total number of rows for pagination with search
$sql_total = "SELECT COUNT(*) AS total FROM PX_ITEMS WHERE ITEM_CODE LIKE ? OR ITEM_PROD_DESC LIKE ?";
$params_total = ["%$search_query%", "%$search_query%"];
$stmt_total = sqlsrv_query($conn, $sql_total, $params_total);
$total_items = sqlsrv_fetch_array($stmt_total, SQLSRV_FETCH_ASSOC)['total'];
$total_pages = ceil($total_items / $items_per_page);

// Free total rows statement
sqlsrv_free_stmt($stmt_total);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PX_ITEMS Product Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .search-bar {
            margin: 20px 0;
        }
        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 15px;
            text-align: center;
            background-color: #fff;
        }
        .card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .card h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .card p {
            margin: 5px 0;
        }
        .pagination {
            display: flex;
            justify-content: center;
            padding: 10px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .pagination a:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .pagination span {
            margin: 0 5px;
            padding: 8px 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <h1>Auto Tyre Mart Products</h1>

    <div class="search-bar">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Search by code or description..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <?php
        // Fetch and display data in product cards
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<div class='card'>";
            echo "<img src='tyre.png' alt='Product Image'>"; // Temporary image placeholder
            
            echo "<p><strong>Price:</strong> " . htmlspecialchars($row['ITEM_PRICE']) . "</p>";
            echo "<p><strong>Stock:</strong> " . htmlspecialchars($row['ITEM_STOCK']) . "</p>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($row['ITEM_PROD_DESC']) . "</p>";
            echo "</div>";
        }

        // Free statement
        sqlsrv_free_stmt($stmt);
        ?>
    </div>

    <div class="pagination">
        <?php
        $range = 4; // Number of page links to show
        $start = max(1, $page - intval($range / 2)); // Calculate start of range
        $end = min($total_pages, $start + $range - 1); // Calculate end of range

        if ($start > 1) {
            echo "<a href='?page=1&search=" . urlencode($search_query) . "'>1</a>";
            if ($start > 2) echo "<span>...</span>"; // Ellipsis if there's a gap
        }

        for ($i = $start; $i <= $end; $i++) {
            $active = $i === $page ? 'active' : '';
            echo "<a href='?page=$i&search=" . urlencode($search_query) . "' class='$active'>$i</a>";
        }

        if ($end < $total_pages) {
            if ($end < $total_pages - 1) echo "<span>...</span>"; // Ellipsis if there's a gap
            echo "<a href='?page=$total_pages&search=" . urlencode($search_query) . "'>$total_pages</a>";
        }
        ?>
    </div>

    <?php
    // Close connection
    sqlsrv_close($conn);
    ?>
</body>
</html>
