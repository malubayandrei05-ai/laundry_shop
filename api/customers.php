<?php
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET ALL CUSTOMERS
if ($method == 'GET') {

    $sql = "SELECT * FROM customers ORDER BY customer_id DESC";
    $result = $conn->query($sql);

    $customers = [];

    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $customers
    ]);
}
// ADD CUSTOMER
if ($method == 'POST') {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers(name, contact, address)
            VALUES('$name', '$contact', '$address')";

    if ($conn->query($sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Customer added successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to add customer"
        ]);
    }
}
?>
