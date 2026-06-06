<?php
if(!empty($_GET["action"])) 
{
    session_start(); // ensure session is started
    include("connection/connect.php"); // DB connection

    $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;

    switch($_GET["action"])
    {
        case "add":
            if(!$user_id){
                echo "<script>alert('Please login first to add items to cart');</script>";
                break;
            }

            if(!empty($quantity) && $productId > 0) {
                // Get dish details
                $stmt = $db->prepare("SELECT * FROM dishes WHERE d_id=?");
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $productDetails = $stmt->get_result()->fetch_object();

                if($productDetails){
                    // Session cart logic
                    $itemArray = array($productDetails->d_id => array(
                        'title' => $productDetails->title,
                        'd_id' => $productDetails->d_id,
                        'quantity' => $quantity,
                        'price' => $productDetails->price
                    ));

                    if(!empty($_SESSION["cart_item"])) {
                        if(array_key_exists($productDetails->d_id, $_SESSION["cart_item"])) {
                            $_SESSION["cart_item"][$productDetails->d_id]["quantity"] += $quantity;
                        } else {
                            $_SESSION["cart_item"] += $itemArray;
                        }
                    } else {
                        $_SESSION["cart_item"] = $itemArray;
                    }

                    // Database cart logic
                    $check = $db->query("SELECT * FROM cart WHERE user_id='$user_id' AND dish_id='$productDetails->d_id'");
                    if($check->num_rows > 0){
                        $db->query("UPDATE cart SET quantity = quantity + $quantity WHERE user_id='$user_id' AND dish_id='$productDetails->d_id'");
                    } else {
                        $db->query("INSERT INTO cart (user_id, dish_id, quantity, price) VALUES ('$user_id','$productDetails->d_id','$quantity','$productDetails->price')");
                    }
                }
            }
            break;

        case "remove":
            if(!empty($_SESSION["cart_item"])){
                foreach($_SESSION["cart_item"] as $k => $v){
                    if($productId == $v['d_id']){
                        unset($_SESSION["cart_item"][$k]);
                        if($user_id){
                            $db->query("DELETE FROM cart WHERE user_id='$user_id' AND dish_id='$productId'");
                        }
                    }
                }
            }
            break;

        case "empty":
            unset($_SESSION["cart_item"]);
            if($user_id){
                $db->query("DELETE FROM cart WHERE user_id='$user_id'");
            }
            break;

        case "check":
            header("Location: checkout.php");
            exit;
            break;
    }
}
?>
