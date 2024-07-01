<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="layout/css/style.css">
   
</head>



<?php
ob_start(); 
session_start();
$pageTitle = 'Home';
include 'init.php';


echo'  <section class="home" id="home">
    <div class="content">
        <h3>Smart Phone Store</h3>
        <p>Shop the latest Apple Products ,accessories and offers .Compare models,get expert shooping help , plus flexible payment and delivery options,
         Discover the innovative world of Apple and shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV. </p>
    <a href="login.php" class="btn">Shop Now</a>  
    <a href="login.php" class="btn">Contact Us</a>

        </div>

    </section>';
   
$stmt = $con->prepare("SELECT * FROM product ");

// Execute The Statement

    $stmt->execute();

// Assign To Variable 

    $rows = $stmt->fetchAll();

   if (! empty($rows)) {
    echo' <section class="products-container">';
    foreach($rows as $row) {
       
        echo' <div class="products">				
        <img class="product-img" src="data:image;base64,'.base64_encode($row['photo']).'" alt="prd1" onmouseover="animateImg(this)"
        onmouseout="normalImg(this)"/>';
		echo " <div class='info'>
        <p> <strong> " . $row['p_name'] ." </strong></p>
        <span>". $row['price'] ."</span>
         </div>
        </div>";
                                
 
    }
    echo ' </section>';
}else {
                                echo '<div class="container">';
                                    echo '<div class="nice-message">There\'s No Product To Show</div>';
                                echo '</div>';
                            
                            } 
                            
 
ob_end_flush();
?>
  <footer class="credit" style="width:100%; height: 30px; text-align: center; font-size: 20px; font-weight: 500;">abdalhkem_188222  &&  Ghufran_267526</footer>
    <script>
        function showLargeImage(largeImageUrl, imageDetails) {
        var newPageUrl = "products.html";
        window.open(newPageUrl);
       sessionStorage.setItem("largeImageUrl", largeImageUrl);
       sessionStorage.setItem("imageDetails", imageDetails);
}
    </script>