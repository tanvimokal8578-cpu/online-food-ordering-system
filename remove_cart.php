<?php
session_start();

$id = $_GET['id'];

if(isset($_SESSION["cart_item"][$id])) {
    unset($_SESSION["cart_item"][$id]);
}

header("location:cart.php");
?>
