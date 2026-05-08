<?php include 'config.php'; include 'header.php';
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    mysqli_query($conn, "INSERT INTO products(product_name, category, price, stock, icon) VALUES('$name','$category','$price','$stock','$icon')");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
}
?>
<h1>🛒 Laundry Products</h1>
<p class="small">Products related to the Laundry Shop Management System.</p>
<form method="POST" class="form-row">
    <input name="product_name" placeholder="Product Name" required>
    <select name="category" required>
        <option value="Detergent">Detergent</option>
        <option value="Fabric Care">Fabric Care</option>
        <option value="Cleaning Supply">Cleaning Supply</option>
        <option value="Packaging">Packaging</option>
        <option value="Laundry Equipment">Laundry Equipment</option>
    </select>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <input name="icon" placeholder="Icon/Emoji" value="🧺" required>
    <button name="add">Add Product</button>
</form>
<div class="product-grid" style="margin-top:18px">
<?php $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC"); while($row=mysqli_fetch_assoc($res)): ?>
<div class="card product-card">
    <div class="emoji"><?php echo $row['icon']; ?></div>
    <span class="tag"><?php echo $row['category']; ?></span>
    <h3><?php echo $row['product_name']; ?></h3>
    <p class="price">₱<?php echo number_format($row['price'],2); ?></p>
    <small>Stock: <?php echo $row['stock']; ?></small><br><br>
    <a class="danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete product?')">Delete</a>
</div>
<?php endwhile; ?>
</div>
<?php include 'footer.php'; ?>
