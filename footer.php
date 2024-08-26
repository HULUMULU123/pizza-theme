<?php 

/**
 * Contains footer
 */

?>

<footer class="footer">
        <div>
          <ul class="docs-link">
            <li class="docs-item"><a href="#" class="doc">Document</a></li>
            <li class="docs-item"><a href="#" class="doc">Document</a></li>
            <li class="docs-item"><a href="#" class="doc">Document</a></li>
          </ul>
        </div>
        <div>
          <ul class="other-docs">
            <li class="other-item"><a href="#" class="doc">Document</a></li>
            <li class="other-item"><a href="#" class="doc">Document</a></li>
            <li class="other-item"><a href="#" class="doc">Document</a></li>
          </ul>
        </div>
        <div><p>all rights reserved © 2024</p></div>
      </footer>
    </div>
    <script>
      const cartLink = document.querySelector('.cart-link');
      console.log(cartLink)
      var cartQuantity = cartLink.createElement('span');
      <?php $count = get_cart_item_count();
        if ($count > 0){
      ?>
      cartQuantity.innerHTML = <?=$count?>
      cartLink.classList.add('cart-quantity')<?php }?>
      var addToCartBtns = document.querySelectorAll('.add_to_cart_button');
      addToCartBtns.forEach((button)=>{
        button.addEventListener('click', ()=>{

        })
      })
    </script>
    <?php wp_footer();?>
  </body>
</html>