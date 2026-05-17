<?php
include 'config.php';
include 'header.php';

if (isset($_POST['pay'])) {

    $order_id = intval($_POST['order_id']);
    $amount = floatval($_POST['amount_paid']);

    $check = mysqli_query($conn, "
        SELECT total_amount 
        FROM orders 
        WHERE id = $order_id
    ");

    $order = mysqli_fetch_assoc($check);
    $total_amount = $order['total_amount'];

    if ($amount < $total_amount) {

        echo "
        <script>
            alert('Insufficient Payment! Kulang ang bayad. Total Amount: ₱$total_amount');
            window.location.href='payments.php';
        </script>
        ";

    } else {

        mysqli_query($conn, "
            INSERT INTO payments(order_id, amount_paid, payment_status, payment_date)
            VALUES($order_id, $amount, 'Paid', CURDATE())
        ");

        echo "
        <script>
            alert('Payment Recorded Successfully!');
            window.location.href='payments.php';
        </script>
        ";
    }
}
?>

<h1>Payments</h1>

<form method="POST" class="form-row">
    <select name="order_id" required>
        <option value="">Select Customer / Order</option>

        <?php
        $o = mysqli_query($conn, "
              SELECT orders.id,
           customers.customer_name,
           orders.total_amount
    FROM orders
    INNER JOIN customers 
        ON orders.customer_id = customers.id

    WHERE orders.id NOT IN (
        SELECT order_id FROM payments
    )

    ORDER BY orders.id DESC
        ");

        while ($r = mysqli_fetch_assoc($o)):
        ?>
            <option value="<?php echo $r['id']; ?>">
                <?php echo $r['customer_name']; ?>
                - Order #<?php echo $r['id']; ?>
                - ₱<?php echo number_format($r['total_amount'], 2); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" step="0.01" name="amount_paid" placeholder="Amount Paid" required>

    <button name="pay">Record Payment</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Order</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    <?php
    $sql = "
        SELECT payments.*,
               customers.customer_name
        FROM payments
        JOIN orders ON payments.order_id = orders.id
        JOIN customers ON orders.customer_id = customers.id
        ORDER BY payments.id DESC
    ";

    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($res)):
    ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>#<?php echo $row['order_id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td>₱<?php echo number_format($row['amount_paid'], 2); ?></td>
            <td><?php echo $row['payment_status']; ?></td>
            <td><?php echo $row['payment_date']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>


<?php include 'footer.php'; ?>