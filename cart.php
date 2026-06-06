<?php
session_start();
include("connection/connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Main Style -->
<link rel="stylesheet" href="css/style.css">

<style>
/* ✅ Top navbar, right-aligned, horizontal line, thicker bar */
.top-navbar {
    background-color: #343a40; /* Dark like footer */
    padding: 15px 20px; /* Thicker bar */
}
.top-navbar ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex; /* horizontal line */
    justify-content: flex-end; /* right-aligned */
    gap: 25px; /* space between links */
}
.top-navbar ul li a {
    color: #f8f9fa; /* light text */
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.top-navbar ul li a:hover {
    color: #ffc107; /* highlight on hover */
}

/* Cart page content spacing */
.cart-page {
    margin-top: 30px; /* space below navbar */
    margin-bottom: 80px; /* space above footer */
}
.cart-page h2 {
    margin-bottom: 30px;
}

/* Footer spacing */
.footer {
    margin-top: 50px;
}
</style>

<script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

<!-- 🔹 TOP NAVBAR -->
<</head>
<body class="home">
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="" width="18%"> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Menu <span class="sr-only"></span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="cart.php">Cart <span class="sr-only"></span></a> </li>
                        

                        <?php
						if(empty($_SESSION["user_id"])) // if user is not login
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
							}
						else
							{

									
									echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}

						?>

                    </ul>

                </div>
            </div>
        </nav>

    </header>  
<!-- 🔹 CART CONTENT -->
<div class="container cart-page">
    <h2 class="text-center">🛒 My Cart</h2>

<?php
if (empty($_SESSION["cart_item"])) {
    echo "<div class='alert alert-warning text-center'>Cart is empty</div>";
} else {
?>

<div class="table-responsive">
<table class="table table-bordered cart-table">
<tr class="bg-dark text-white">
    <th>Food Name</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
$total = 0;
foreach ($_SESSION["cart_item"] as $item) {
    $item_total = $item["price"] * $item["quantity"];
    $total += $item_total;
?>
<tr>
    <td><?php echo $item["title"]; ?></td>
    <td>₹<?php echo $item["price"]; ?></td>
    <td><?php echo $item["quantity"]; ?></td>
    <td>₹<?php echo $item_total; ?></td>
    <td>
        <a href="remove_cart.php?id=<?php echo $item['d_id']; ?>" 
           class="btn btn-danger btn-sm">
           Remove
        </a>
    </td>
</tr>
<?php } ?>

<tr class="fw-bold">
    <td colspan="3" class="text-end">Grand Total</td>
    <td colspan="2">₹<?php echo $total; ?></td>
</tr>
</table>
</div>

<div class="text-center mt-4">
    <a href="checkout.php" class="btn btn-success px-4">Proceed to Order</a>
    <a href="empty_cart.php" class="btn btn-warning px-4">Empty Cart</a>
</div>

<?php } ?>
</div>

<!-- 🔹 FOOTER -->
<?php include "include/footer.php" ?>