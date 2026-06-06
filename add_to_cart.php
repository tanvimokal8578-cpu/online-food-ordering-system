<?php
session_start();
include("connection/connect.php");

if(empty($_SESSION["user_id"])){
    header("location:login.php");
    exit;
}

$user_id  = $_SESSION["user_id"];
$food_id  = $_POST["food_id"];
$name     = $_POST["food_name"];
$price    = $_POST["price"];
$qty      = $_POST["quantity"];

// check same item already cart madhe aahe ka
$check = mysqli_query($conn,
"SELECT * FROM cart WHERE user_id='$user_id' AND food_id='$food_id'");

if(mysqli_num_rows($check) > 0){
    mysqli_query($conn,
    "UPDATE cart SET quantity = quantity + $qty 
     WHERE user_id='$user_id' AND food_id='$food_id'");
} else {
    mysqli_query($conn,
    "INSERT INTO cart (user_id, food_id, food_name, price, quantity)
     VALUES ('$user_id','$food_id','$name','$price','$qty')");
}

header("location:cart.php");
?>
