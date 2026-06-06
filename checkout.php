<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();


function function_alert() { 
      

    echo "<script>alert('Thank you. Your Order has been placed!');</script>"; 
    echo "<script>window.location.replace('your_orders.php');</script>"; 
} 

if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else{

if(isset($_POST['submit']))
{
    $payment_method = $_POST['mod'];

    // ✅ validation
    if($payment_method=="UPI" && empty($_POST['upi_id'])){
        echo "<script>alert('Please enter UPI ID');</script>";
    }
    elseif($payment_method=="CARD" && empty($_POST['card_number'])){
        echo "<script>alert('Please enter Card Details');</script>";
    }
    elseif($payment_method=="NET" && empty($_POST['bank'])){
        echo "<script>alert('Please select bank');</script>";
    }
    else{

        foreach ($_SESSION["cart_item"] as $item)
        {
            if(isset($_POST['submit']))
{
    $payment_method = $_POST['mod'];

    // ✅ Validation
    if($payment_method=="UPI" && empty($_POST['upi_id'])){
        echo "<script>alert('Please enter UPI ID');</script>";
    }
    elseif($payment_method=="CARD" && empty($_POST['card_number'])){
        echo "<script>alert('Please enter Card Details');</script>";
    }
    elseif($payment_method=="NET" && empty($_POST['bank'])){
        echo "<script>alert('Please select bank');</script>";
    }
    else
    {
        // ✅ Payment Status Logic
        if($payment_method == "COD"){
            $payment_status = "Pending";
        } else {
            $payment_status = "Paid";
        }

        foreach ($_SESSION["cart_item"] as $item)
        {
            $SQL="INSERT INTO users_orders
            (u_id,title,quantity,price,payment_method,payment_status)
            VALUES
            ('".$_SESSION["user_id"]."',
             '".$item["title"]."',
             '".$item["quantity"]."',
             '".$item["price"]."',
             '".$payment_method."',
             '".$payment_status."')";

            mysqli_query($db,$SQL);
        }

        unset($_SESSION["cart_item"]);
        function_alert();
        exit();
    }
}
            $SQL="INSERT INTO users_orders(u_id,title,quantity,price,payment_method,payment_status)
                  VALUES('".$_SESSION["user_id"]."',
                         '".$item["title"]."',
                         '".$item["quantity"]."',
                         '".$item["price"]."',
                         '".$payment_method."',
                         'Pending')";

            mysqli_query($db,$SQL);
        }

        unset($_SESSION["cart_item"]);
        $success = "Thank you. Your order has been placed!";
        function_alert();
    }
}
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Checkout || Online Food Ordering System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>    
    <div class="site-wrapper">
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="" width="18%"> </a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Menu <span class="sr-only"></span></a> </li>

                            <?php
						if(empty($_SESSION["user_id"]))
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
        <div class="page-wrapper">
            <div class="top-links">
                <div class="container">
                    <ul class="row links">

                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and Pay</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">

                <span style="color:green;">
                    <?php echo $success; ?>
                </span>

            </div>
            <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">

                        <div class="widget-body">
                            <form method="post" action="#">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="cart-totals margin-b-20">
                                            <div class="cart-totals-title">
                                                <h4>Cart Summary</h4>
                                            </div>
                                            <div class="cart-totals-fields">

                                                <table class="table">
                                                    <tbody>
                                                      
                                                        <tr>
                                                            <td>Cart Subtotal</td>
                                                            <td> <?php echo "Rs".$item_total; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Delivery Charges</td>
                                                            <td>Free</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-color"><strong>Total</strong></td>
                                                            <td class="text-color"><strong> <?php echo "Rs".$item_total; ?></strong></td>
                                                        </tr>
                                                    </tbody>                                                  
                                                </table>
                                            </div>
                                        </div>
                                        <div class="payment-option">
                                            <ul class="list-unstyled">
    <li>
        <label class="custom-control custom-radio m-b-20">
            <input name="mod" type="radio" value="COD" checked onclick="showPay('cod')" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Cash on Delivery</span>
        </label>
    </li>

    <li>
        <label class="custom-control custom-radio m-b-10">
            <input name="mod" type="radio" value="CARD" onclick="showPay('card')" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Card</span>
        </label>
    </li>

    <li>
        <label class="custom-control custom-radio m-b-10">
            <input name="mod" type="radio" value="UPI" onclick="showPay('upi')" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">UPI</span>
        </label>
    </li>

    <li>
        <label class="custom-control custom-radio m-b-10">
            <input name="mod" type="radio" value="NET" onclick="showPay('net')" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Net Banking</span>
        </label>
    </li>
</ul>
<!-- CARD -->
<div id="cardBox" style="display:none;">
    <h5>Card Details</h5>
    <input type="text" name="card_name" class="form-control mb-2" placeholder="Card Holder Name">
    <input type="text" name="card_number" class="form-control mb-2" placeholder="Card Number">
    <input type="text" name="expiry" class="form-control mb-2" placeholder="MM/YY">
    <input type="text" name="cvv" class="form-control mb-2" placeholder="CVV">
</div>

<!-- UPI -->
<div id="upiBox" style="display:none;">
    <h5>UPI Payment</h5>
    <input type="text" name="upi_id" class="form-control mb-2" placeholder="example@upi">
</div>

<!-- NET BANKING -->
<div id="netBox" style="display:none;">
    <h5>Select Bank</h5>
    <select name="bank" class="form-control mb-2">
        <option>Select Bank</option>
        <option>SBI</option>
        <option>HDFC</option>
        <option>Bol</option>
        <option>AXIS</option>
    </select>
</div>
                                            <p class="text-xs-center"> <input type="submit" onclick="return confirm('Do you want to confirm the order?');" name="submit" class="btn btn-success btn-block" value="Order Now"> </p>
                                        </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>
        </form>
    </div>
    <?php include "include/footer.php" ?>
    </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
<script>
function showPay(type) {
    document.getElementById("cardBox").style.display = "none";
    document.getElementById("upiBox").style.display = "none";
    document.getElementById("netBox").style.display = "none";

    if (type === "card") {
        document.getElementById("cardBox").style.display = "block";
    }
    if (type === "upi") {
        document.getElementById("upiBox").style.display = "block";
    }
    if (type === "net") {
        document.getElementById("netBox").style.display = "block";
    }
}
</script>

</body>

</html>
<?php
}
?>
