<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CodeHim">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
   
    <link rel="stylesheet" href="layout/css/shooping.css">
	<link rel="stylesheet" href="layout/css/demo.css">
 
  
  </head>

<?php

	$pageTitle = 'Shooping';
	$noNavbar = '';
	
		include 'init.php';
	
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			
					
$stmt = $con->prepare("SELECT * FROM product ");
$stmt->execute();
$rows = $stmt->fetchAll();

   if (! empty($rows)) {

echo'
<main>
    <div class="AAA">
     <div class="row">
       <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
         <h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center">Products</h4>';
        
       echo'   <div class="row">'; 
         foreach($rows as $row) {
        echo' 
           <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
             <div class="shadow-sm card mb-3 product">
              	<img class="product-img" src="data:image;base64,'.base64_encode($row['photo']).'" alt="prd1" onmouseover="animateImg(this)"
	onmouseout="normalImg(this)"/>
               <div class="card-body">
                 <h5 class="card-title text-info bold product-name">'.$row['p_name'].'</h5>
                 <p class="card-text text-success product-price">'.$row['price'].'</p>
                 <button class="btn badge badge-pill badge-secondary mt-2 float-right" type="button"
                   data-action="add-to-cart">Add to cart</button>
               </div>
             </div>
           </div>';
         
    
}
 echo '</div>
	     </div>';
  	

 echo' 
        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
          <h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center">Cart</h4>
          <div class="cart"></div>
      
         </div>';
     
       
 echo' <div class="checkout" id="Chechout" onclick= "document.getElementById("id01").style.display="block" ">Check out</div>';
	
 echo '<div id="id01" class="modal">
      <div class="wrapper">
        <div class="bill-content">
        <span onclick="document.getElementById("id01").style.display="none"" class="close" title="Close">&times;</span>
        <h1 class="box-title">Checkout</h1>
        <div class="price-total">
          <div class="pay-last">$ 0</div>
        </div>
        <form>
          
          <div class="form-text">
            <label>Card Number</label>
            <input name="card-number" type="text" required>
          </div>
          <div class="form-text">
            <label>Card Verification Value</label>
            <input name="name" type="text"  required>
          </div>
          <div class="form-text" id="col01">
            <label>Expiry Date</label>
            <input name="card-number" type="text"  maxlength="3" required>
          </div>
          <div class="form-text"  id="col02">
            <label>Coupon Code</label>
            <input name="card-number" type="text">
          </div>
          
          <button id="end">PAY NOW</button>
        </form>
          <button id="coupon">Get coupon code</button>
        </div>
      </div>
     </div>
    </div>  
 </main>';
	} else {

echo'   
	<div class="container">
	<div class="nice-message">There\'s No Product To Show</div>
	</div>';

	
}
	
}elseif ($do =='Insert') {
	if  ($_SERVER['REQUEST_METHOD'] == 'POST') {

		echo "<h1 class='text-center'>Insert To the Card</h1>";
		echo "<div class='container'>";

		
		$Uid  = $_SESSION['ID'];
		$Pid = $_POST['Pid'];
		$card = $_POST['card-number'];
		$date= $_POST['date'];

				$stmt = $con->prepare("INSERT INTO 
											card(user_id,pid ,card_num,date)
										VALUES(:ZUid , :zPid,:zcard, now() )");
				$stmt->execute(array(

					 
					'ZUid'     => $Uid,
					'zPid'     => $Pid, 
					'zcard_num'     =>  $card 
				));

				// Echo Success Message

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

				redirectHome($theMsg, 'back');


		}

	echo "</div>";



 
 
 // include $tpl . 'footer.php';

} else {

	header('Location: index.php');

	exit();
}
	
ob_end_flush(); // Release The Output

?>

<script>
"use strict";                        
let cart = [];
let cartTotal = 0;
const cartDom = document.querySelector(".cart");
const addtocartbtnDom = document.querySelectorAll('[data-action="add-to-cart"]');

addtocartbtnDom.forEach(addtocartbtnDom => {
  addtocartbtnDom.addEventListener("click", () => {
    const productDom = addtocartbtnDom.parentNode.parentNode;
    const product = {
      img: productDom.querySelector(".product-img").getAttribute("src"),
      name: productDom.querySelector(".product-name").innerText,
      price: productDom.querySelector(".product-price").innerText,
      quantity: 1
   };

const IsinCart = cart.filter(cartItem => cartItem.name === product.name).length > 0;
if (IsinCart === false) {
  cartDom.insertAdjacentHTML("beforeend",`
  <div class="d-flex flex-row shadow-sm card cart-items mt-2 mb-3 animated flipInX">
    <div class="p-2">
        <img src="${product.img}" alt="${product.name}" style="max-width: 50px;"/>
    </div>
    <div class="p-2 mt-3">
        <p class="text-info cart_item_name">${product.name}</p>
    </div>
    <div class="p-2 mt-3">
        <p class="text-success cart_item_price">${product.price}</p>
    </div>
    <div class="p-2 mt-3 ml-auto">
        <button class="btn badge badge-secondary" type="button" data-action="increase-item">&plus;
    </div>
    <div class="p-2 mt-3">
      <p class="text-success cart_item_quantity">${product.quantity}</p>
    </div>
    <div class="p-2 mt-3">
      <button class="btn badge badge-info" type="button" data-action="decrease-item">&minus;
    </div>
    <div class="p-2 mt-3">
      <button class="btn badge badge-danger" type="button" data-action="remove-item">&times;
    </div>
  </div> `);

  if(document.querySelector('.cart-footer') === null){
    cartDom.insertAdjacentHTML("afterend",  `
      <div class="d-flex flex-row shadow-sm card cart-footer mt-2 mb-3 animated flipInX">
        <div class="p-2">
          <button class="btn badge-danger" type="button" data-action="clear-cart">Clear Cart
        </div>
        <div class="p-2 ml-auto">
          <button class="btn badge-dark" type="button" data-action="check-out">Pay <span class="pay"></span> 
    
        </div>
      </div>`); }

    addtocartbtnDom.innerText = "In cart";
    addtocartbtnDom.disabled = true;
    cart.push(product);

    const cartItemsDom = cartDom.querySelectorAll(".cart-items");
    cartItemsDom.forEach(cartItemDom => {

    if (cartItemDom.querySelector(".cart_item_name").innerText === product.name) {

      cartTotal += parseInt(cartItemDom.querySelector(".cart_item_quantity").innerText) 
      * parseInt(cartItemDom.querySelector(".cart_item_price").innerText);
      document.querySelector('.pay').innerText = cartTotal + " Rs.";

      // increase item in cart
      cartItemDom.querySelector('[data-action="increase-item"]').addEventListener("click", () => {
        cart.forEach(cartItem => {
          if (cartItem.name === product.name) {
            cartItemDom.querySelector(".cart_item_quantity").innerText = ++cartItem.quantity;
            cartItemDom.querySelector(".cart_item_price").innerText = parseInt(cartItem.quantity) *
            parseInt(cartItem.price) + " Rs.";
            cartTotal += parseInt(cartItem.price)
            document.querySelector('.pay').innerText = cartTotal + " Rs.";
          }
        });
      });

      // decrease item in cart
      cartItemDom.querySelector('[data-action="decrease-item"]').addEventListener("click", () => {
        cart.forEach(cartItem => {
          if (cartItem.name === product.name) {
            if (cartItem.quantity > 1) {
              cartItemDom.querySelector(".cart_item_quantity").innerText = --cartItem.quantity;
              cartItemDom.querySelector(".cart_item_price").innerText = parseInt(cartItem.quantity) *
              parseInt(cartItem.price) + " Rs.";
              cartTotal -= parseInt(cartItem.price)
              document.querySelector('.pay').innerText = cartTotal + " Rs.";
            }
          }
        });
      });

      //remove item from cart
      cartItemDom.querySelector('[data-action="remove-item"]').addEventListener("click", () => {
        cart.forEach(cartItem => {
          if (cartItem.name === product.name) {
              cartTotal -= parseInt(cartItemDom.querySelector(".cart_item_price").innerText);
              document.querySelector('.pay').innerText = cartTotal + " Rs.";
              cartItemDom.remove();
              cart = cart.filter(cartItem => cartItem.name !== product.name);
              addtocartbtnDom.innerText = "Add to cart";
              addtocartbtnDom.disabled = false;
          }
          if(cart.length < 1){
            document.querySelector('.cart-footer').remove();
          }
        });
      });

      //clear cart
      document.querySelector('[data-action="clear-cart"]').addEventListener("click" , () => {
        cartItemDom.remove();
        cart = [];
        cartTotal = 0;
        if(document.querySelector('.cart-footer') !== null){
          document.querySelector('.cart-footer').remove();
        }
        addtocartbtnDom.innerText = "Add to cart";
        addtocartbtnDom.disabled = false;
      });

      document.querySelector('[data-action="check-out"]').addEventListener("click" , () => {
        if(document.getElementById('paypal-form') === null){
          checkOut();
        }
      });
    }
  });
}
});
});

function animateImg(img) {
  img.classList.add("animated","shake");
}

function normalImg(img) {
  img.classList.remove("animated","shake");
}

</script>