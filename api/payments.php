<?php
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {

    $sql = "SELECT * FROM payments ORDER BY payment_id DESC";
    $result = $conn->query($sql);

    $payments = [];

    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $payments
    ]);
}

if ($method == 'POST') {

    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    $sql = "INSERT INTO payments(order_id, amount, payment_method)
            VALUES('$order_id', '$amount', '$payment_method')";

    if ($conn->query($sql)) {

        $conn->query("UPDATE orders SET status='Paid' WHERE order_id='$order_id'");

        echo json_encode([
            "success" => true,
            "message" => "Payment successful"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Payment failed"
        ]);
    }
}
?>
