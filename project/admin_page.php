<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>


<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings_query = mysqli_query($conn, "SELECT SUM(p.price * o.quantity) AS total_price
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE o.payment_status = 'pending'") or die('query failed');
            $total_pendings_row = mysqli_fetch_assoc($total_pendings_query);
            $total_pendings = $total_pendings_row['total_price'];
         ?>
         <h3>$<?php echo $total_pendings; ?>/-</h3>
         <p>total pendings</p>
      </div>

      <div class="box">
         <?php
            $total_completed_query = mysqli_query($conn, "SELECT SUM(p.price * o.quantity) AS total_price
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE o.payment_status = 'completed'") or die('query failed');
            $total_completed_row = mysqli_fetch_assoc($total_completed_query);
            $total_completed = $total_completed_row['total_price'];
         ?>
         <h3>$<?php echo $total_completed; ?>/-</h3>
         <p>completed payments</p>
      </div>

      <div class="box">
         <?php 
            $select_pending_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending' OR payment_status IS NULL") or die('query failed');
            $number_of_pending_orders = mysqli_num_rows($select_pending_orders);
         ?>
         <h3><?php echo $number_of_pending_orders; ?></h3>
         <p>pending orders</p>
      </div>

      <div class="box">
         <?php 
            $select_completed_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            $number_of_completed_orders = mysqli_num_rows($select_completed_orders);
         ?>
         <h3><?php echo $number_of_completed_orders; ?></h3>
         <p>completed orders</p>
      </div>

      <div class="box">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>order placed</p>
      </div>

      <div class="box">
         <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>products added</p>
      </div>

      <div class="box">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>normal users</p>
      </div>

      <div class="box">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
         <h3><?php echo $number_of_admins; ?></h3>
         <p>admin users</p>
      </div>

   </div>

</section>



<section class="show-products">
<h1 class="title">BEST-BUY PRODUCTS</h1>
   <div class="box-container">
      <?php
         $select_products = mysqli_query($conn, "SELECT p.*, total_quantity
         FROM products p
         JOIN (
             SELECT o.product_id, SUM(o.quantity) AS total_quantity
             FROM orders o
             GROUP BY o.product_id
             HAVING SUM(o.quantity) = (
                 SELECT MAX(total_quantity)
                 FROM (
                     SELECT SUM(quantity) AS total_quantity
                     FROM orders
                     GROUP BY product_id
                 ) AS quantities
             )
         ) AS top_products ON p.product_id = top_products.product_id") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>


<script src="js/admin_script.js"></script>

</body>
</html>