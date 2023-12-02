<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){
   $method = mysqli_real_escape_string($conn, $_POST['method']);

   $required_date = $_POST['required_date'];

   $cart_total = 0;
   $cart_id = 0;
   $cart_products = array();

   $cart_query = mysqli_query($conn, "SELECT c.*,
   (SELECT p.price
   FROM products p
   WHERE p.product_id = c.product_id) AS price,
   (SELECT p.name
   FROM products p
   WHERE p.product_id = c.product_id) AS name
   FROM cart c
   WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $product = array(
            'product_id' => $cart_item['product_id'],
            'quantity' => $cart_item['quantity']
         );
         $cart_products[] = $product;
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }


   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
         foreach ($cart_products as $cart_item) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];

            mysqli_query($conn, "INSERT INTO `orders` (user_id, method, product_id, quantity, placed_on, required_date)
               VALUES ('$user_id', '$method', '$product_id','$quantity', CURDATE(), '$required_date')") or die('query failed');
         }
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT c.*,
      (SELECT p.price
      FROM products p
      WHERE p.product_id = c.product_id) AS price,
      (SELECT p.name
      FROM products p
      WHERE p.product_id = c.product_id) AS name
      FROM cart c
      WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
               <option value="visa">paytm</option>
            </select>
         </div>

         <div class="inputBox">
            <span>Required date :</span>
            <?php
               $minDate = date('Y-m-d', strtotime('+3 days')); // Lấy ngày hiện tại cộng thêm 3 ngày
            ?>
            <input type="date" name="required_date" required min="<?php echo $minDate; ?>">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>





<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>