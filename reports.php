<?php include 'config.php'; include 'header.php'; ?>

<h1>Reports</h1>

<?php
$today = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT IFNULL(SUM(amount_paid),0) AS total
    FROM payments
    WHERE payment_status='Paid'
    AND payment_date = CURDATE()
"))['total'];

$month = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT IFNULL(SUM(amount_paid),0) AS total
    FROM payments
    WHERE payment_status='Paid'
    AND MONTH(payment_date)=MONTH(CURDATE())
    AND YEAR(payment_date)=YEAR(CURDATE())
"))['total'];
?>

<div class="cards">
    <div class="card">
        <h3>Today's Sales</h3>
        <p>₱<?php echo number_format($today,2); ?></p>
    </div>

    <div class="card">
        <h3>This Month's Sales</h3>
        <p>₱<?php echo number_format($month,2); ?></p>
    </div>
</div>

<h2>All Orders Report</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

<?php
$sql = "
    SELECT 
        orders.id AS order_id,
        customers.customer_name,
        orders.total_amount,

        CASE
            WHEN payments.order_id IS NOT NULL THEN 'Paid'
            ELSE 'Pending'
        END AS payment_status,

        IFNULL(payments.payment_date, 'Not Yet Paid') AS payment_date

    FROM orders

    JOIN customers 
        ON orders.customer_id = customers.id

    LEFT JOIN payments 
        ON orders.id = payments.order_id

    ORDER BY orders.id DESC
";

$res = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($res)):
?>

    <tr>
        <td><?php echo $row['order_id']; ?></td>

        <td><?php echo $row['customer_name']; ?></td>

        <td>₱<?php echo number_format($row['total_amount'],2); ?></td>

        <td>
            <?php
            if ($row['payment_status'] == 'Paid') {
                echo "<span style='color:lime;font-weight:bold;'>Paid</span>";
            } else {
                echo "<span style='color:red;font-weight:bold;'>Pending</span>";
            }
            ?>
        </td>

        <td><?php echo $row['payment_date']; ?></td>
    </tr>

<?php endwhile; ?>

</table>

<?php include 'footer.php'; ?>