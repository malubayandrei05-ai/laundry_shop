<?php
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET ORDERS
if ($method == 'GET') {

    $sql = "SELECT * FROM orders ORDER BY order_id DESC";
    $result = $conn->query($sql);

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $orders
    ]);
}

// ADD ORDER
if ($method == 'POST') {

    $customer_id = $_POST['customer_id'];
    $service = $_POST['service'];
    $weight = $_POST['weight'];
    $total = $_POST['total'];
    $status = 'Pending';

    $sql = "INSERT INTO orders(customer_id, service, weight, total, status)
            VALUES('$customer_id', '$service', '$weight', '$total', '$status')";

    if ($conn->query($sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Order created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to create order"
        ]);
    }
}
?>
