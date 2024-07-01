<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="layout/css/style.css">
    <link rel="stylesheet" href="layout/css/products.css">
</head>

<?php
	
ob_start(); 

	session_start();
	$pageTitle = 'Product';
	$noNavbar = '';
	
	
	include 'init.php';
	echo'	
<body onload="showImageDetails()">';  
$stmt = $con->prepare("SELECT * FROM product ");

// Execute The Statement

    $stmt->execute();

// Assign To Variable 

    $rows = $stmt->fetchAll();

   if (! empty($rows)) {

    foreach($rows as $row) {
       
 echo'
<div class="product">
<div class="product-container">
  <img class="product-img" src="data:image;base64,'.base64_encode($row['photo']).'" alt="prd1">
  <div class="product-info">
	<p id ="image-details"></p>
	<p class="product-price">'. $row["price"] .'</p>
  </div>
</div>
</div>
';
	}
}
 ob_end_flush();
?>
 
 <script>
function showImageDetails() {
var largeImageUrl = sessionStorage.getItem("largeImageUrl");
var imageDetails = sessionStorage.getItem("imageDetails");
var image = document.getElementById("large-image");
image.src = largeImageUrl;
var details = document.getElementById("image-details");
details.textContent = imageDetails;
}
</script>
		
    									
	
						

 
	