<?php
include 'config.php';

$sql = "SELECT
        COUNT(*) AS total_orders,
        SUM(total) AS total_sales
        FROM orders
        WHERE status='Paid'";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "report" => $data
]);
?>
