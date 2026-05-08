<?php include 'config.php'; include 'header.php'; ?>
<h1>Reports</h1>
<?php
$today=mysqli_fetch_assoc(mysqli_query($conn,"SELECT IFNULL(SUM(amount_paid),0) AS total FROM payments WHERE payment_status='Paid' AND payment_date=CURDATE()"))['total'];
$month=mysqli_fetch_assoc(mysqli_query($conn,"SELECT IFNULL(SUM(amount_paid),0) AS total FROM payments WHERE payment_status='Paid' AND MONTH(payment_date)=MONTH(CURDATE()) AND YEAR(payment_date)=YEAR(CURDATE())"))['total'];
?>
<div class="cards"><div class="card"><h3>Today's Sales</h3><p>₱<?php echo number_format($today,2); ?></p></div><div class="card"><h3>This Month's Sales</h3><p>₱<?php echo number_format($month,2); ?></p></div></div>
<h2>Paid Transactions</h2>
<table><tr><th>Payment ID</th><th>Order ID</th><th>Customer</th><th>Amount</th><th>Date</th></tr>
<?php $sql="SELECT payments.*, customers.customer_name FROM payments JOIN orders ON payments.order_id=orders.id JOIN customers ON orders.customer_id=customers.id WHERE payments.payment_status='Paid' ORDER BY payments.payment_date DESC"; $res=mysqli_query($conn,$sql); while($row=mysqli_fetch_assoc($res)): ?>
<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['order_id']; ?></td><td><?php echo $row['customer_name']; ?></td><td>₱<?php echo number_format($row['amount_paid'],2); ?></td><td><?php echo $row['payment_date']; ?></td></tr>
<?php endwhile; ?></table>
<?php include 'footer.php'; ?>
