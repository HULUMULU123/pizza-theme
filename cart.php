<?php 
/*
Template Name: cart
Template Post Type: post, page, product
*/




get_header();
?>
<div class="cart-grid">
<div class="items-div">
<?php 
if (class_exists('WooCommerce')){

  $cart_items = WC()->cart->get_cart();

  if(!empty($cart_items)){
    echo '<ul class="cart-items">';
    foreach ($cart_items as $cart_item_key=>$cart_item){
      $product_id = $cart_item['product_id'];
      $product = wc_get_product( $product_id );
      $product_name = $product->get_name();
      $product_price = wc_price( $product->get_price() );
      $product_quantity = $cart_item['quantity'];

      echo '<li class="cart-item" id="'. esc_html( $product_id ) .'">';
      echo '<h3 class="cart-item-heading">' . esc_html( $product_name ) . '</h3>';
      // echo '<span>' . esc_html( $product_name ) . '</span>';
      echo '<div class="cart-item-quantity">';
      echo '<input type="button" value="-" placeholder="-" class="change-quantity minus" />';
      echo '<span class="item-quantity">Quantity: ' . esc_html( $product_quantity ) . '</span>';
      echo '<input type="button" value="+" placeholder="+" class="change-quantity plus"/>';
      echo '</div>';
      echo '<span class="item-price">Price: ' . $product_price  . '</span>';
      echo '<input type="button" value="Delete" placeholder="Delete"/ class="delete-btn">';
      echo '</li>';
    }
    echo '</ul>';
} else {
  echo '<div class="cart-items">';
    echo '<p class="empty-cart">Your cart is empty.</p>';
    echo '</div>';
}
}
?>
</div>
<div class="cart-total">
  <ul>
    <li>Cart items: <span class="cart-total-price"></span></li>
    
    <li>Delivery: <span class="shipping-price"></span></li>
    <span></span>
    <li>Total: <span class="total-price"></span> ₽</li>
  </ul>
</div>
<form method="POST" class="cart-buttons" id="ccustomer-form">
  <input type="text" name="name" class="customer-information" placeholder="Enter your name" required>
  <label for="name" class="information-label">Name</label>
  <input type="email" name="email" class="customer-information" placeholder="Enter your email" required>
  <label for="email" class="information-label">Email</label>
  <input type="text" name="address" class="customer-information" placeholder="Enter your address" required>
  <label for="address" class="information-label">Address</label>
  <input class="order-btn" type="submit" placeholder="Order now!" value="Order now!" id="order">
</form>
</div>
<?php 
my_theme_script();   
get_footer();
?>
