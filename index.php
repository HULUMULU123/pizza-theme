<?php 
/**
 * 
 */




get_header();
?>
   
    <main>
        <section class="section-hero">
          <div class="circle"></div>
          <div class="wrapper">
            <div class="hero-text">
              <h1 class="section-heading">Italian restaurant</h1>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta
                accusamus nesciunt veniam debitis numquam odio.
              </p>
              <div class="hero-links">
                <a href="" # class="hero-orange-link">Order now</a>
                <a href="#" class="hero-green-link">Reservation</a>
              </div>
            </div>
            <div class="hero-img">
              <!-- <img src="/img/food.png" alt="hero-img" class="hero-img-item" /> -->
              <img src="<?php echo get_template_directory_uri(); ?>/images/food.png" alt="<?php bloginfo('name'); ?>" class="logo-img hero-img-item-1">
            </div>
          </div>
          <div class="hero-img2">
              <!-- <img src="/img/food.png" alt="hero-img" class="hero-img-item" /> -->
              <img src="<?php echo get_template_directory_uri(); ?>/images/food.png" alt="<?php bloginfo('name'); ?>" class="logo-img hero-img-item-1">
          </div>
        </section>

        <?php
// Получаем все категории товаров
$categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true, // Показывать только категории с товарами
) );


echo '<section class="section-pizza">';
echo '<div class="wrapper">';
// Проверяем, есть ли категории
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
    
    foreach ( $categories as $category ) {
       
      $lowerCaseCategory = strtolower($category->name);
        echo "<div class='food-category' id='{$lowerCaseCategory}'>";
        
        echo '<h1 class="section-heading">' . esc_html( $category->name ) . '</h1>';
        if ( ! empty( $category->description ) ) {
            echo '<p>' . esc_html( $category->description ) . '</p>';
        }
        

        // Вставляем код для отображения товаров в данной категории
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 10, // Количество товаров для показа
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                ),
            ),
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            echo '<ul class="section-list">';
            while ( $query->have_posts() ) {
                $query->the_post();
                wc_get_template_part( 'content', 'product' ); // Шаблон для отображения товара
                
            }
            echo '</ul>';
        } else {
            echo '<p>Товары не найдены в этой категории.</p>';
        }

        wp_reset_postdata(); // Сброс пост данных после WP_Query

        echo '</div>';
    }
    
} else {
    echo $categories;
}
echo '</div>';
echo '</section>';

global $woocommerce;
$cart_items = $woocommerce->cart->get_cart();

foreach ($cart_items as $cart_item_key => $cart_item) {
    $product_id = $cart_item['product_id'];
    $quantity = $cart_item['quantity'];
    $product_name = $cart_item['data']->get_name();
    
    
}
?>
<section class="section-contacts" id="contacts">
<h1 class="section-heading">Contacts</h1>
  <div>
    <iframe
      src="https://yandex.ru/map-widget/v1/?um=constructor%3A6f2bee012088c88cfc4f1dd4a6f916ad59b9811509ea66d96d6719d4e5793273&amp;source=constructor"
      width="100%"
      height="100%"
      frameborder="0"
    ></iframe>
  </div>
  <div><img src="<?php echo get_template_directory_uri(); ?>/images/sale.jpg" alt="" /></div>
  <div><img src="<?php echo get_template_directory_uri(); ?>/images/sale.jpg" alt="" /></div>
</section>
<?php 
my_theme_script();   
get_footer();
?>