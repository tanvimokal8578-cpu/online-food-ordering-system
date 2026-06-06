<?php
session_start();
unset($_SESSION["cart_item"]);
header("location:cart.php");
?>
