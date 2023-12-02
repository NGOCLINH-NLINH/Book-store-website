<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Welcome to our online book shop. Discover a vast collection of books spanning various genres.</p>
         <p>With our user-friendly interface, you can easily search, browse, and purchase your favorite titles, ensuring that your reading list is always brimming with captivating adventures and profound insights. Whether you're seeking an escape into fictional realms or a deep dive into non-fictional realms of knowledge, our online book shop is your gateway to a world of endless imagination.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>I absolutely love shopping at this online book shop! Their vast selection of books caters to every reader's interest, and their user-friendly website makes browsing and purchasing a breeze. The swift delivery and excellent customer service are the cherry on top. Highly recommended!</p>
         <h3>John Legend</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>What a fantastic online book shop! The quality of their books is top-notch, and I always find the latest releases and hidden gems in their collection. The seamless ordering process and prompt shipment ensure that I can indulge in my reading passion without any hassle. A must-visit for all bookworms!</p>
         <h3>Taylor Swift</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>I can't speak highly enough of this online book shop. The prices are competitive, and the range of genres and authors they offer is remarkable. Whether I'm searching for a gripping thriller or a thought-provoking literary masterpiece, they never disappoint. Their dedication to customer satisfaction is evident in every aspect of their service.</p>
         <h3>Post Malone</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.png" alt="">
         <p>A book lover's paradise! This online book shop has become my go-to destination for all my reading needs. With their extensive catalog, I can explore new titles and find old favorites with ease. The seamless shopping experience, secure packaging, and timely delivery make it a truly delightful place to discover and indulge in the joy of reading.</p>
         <h3>Alicia Brown</h3>
      </div>

      <div class="box">
         <img src="images/pic-5.png" alt="">
         <p>I'm incredibly impressed with the online book shop's commitment to customer satisfaction. Their knowledgeable and friendly support team is always ready to assist with any inquiries or concerns. The seamless return and exchange process further demonstrate their dedication to ensuring a delightful shopping experience.</p>
         <h3>Chris Bratt</h3>
      </div>

      <div class="box">
         <img src="images/pic-6.png" alt="">
         <p>This online book shop goes above and beyond to foster a sense of community among book enthusiasts. Their blog, author interviews, and book recommendations add an extra layer of engagement and discovery. It's not just a place to buy books; it's a hub for bibliophiles to connect and share their love for literature.</p>
         <h3>Ngoc Nguyen</h3>
      </div>

   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>