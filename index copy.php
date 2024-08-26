<?php 
/**
 * 
 */




get_header();
?>
    // if(have_posts()):
    //     while(have_posts()):
    //         the_post();
    //         // get_template_part('template-parts/post/content');
    //         the_title( );
    //         the_content( );
    //     endwhile;
    // endif;
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
              <img src="/img/food.png" alt="hero-img" class="hero-img-item" />
            </div>
          </div>
        </section>

        <section class="section-pizza">
          <div class="wrapper">
            <div class="food-category" id="pizza">
              <h1 class="section-heading">Pizza</h1>
              <ul class="section-list">
                <?php 
                $args = array(
                    'tag' => 'pizza',
                    'posts_per_page' => '20',
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()){
                    while ($the_query->have_posts()){
                        echo '<li class="section-item">';
                        $the_query->the_post();
                        echo '<div class="section-img">';
                        echo get_post_images_only(get_the_ID());
                    // <img src="/img/food.png" alt="section-img" />
                    
                  echo '</div>';
                  $image_url = wp_get_attachment_url(get_the_ID(), 'full');
                  $idd = get_the_ID(  );
                  
                  echo "<h1>{$image_url}</h1>";
                  echo '<div class="section-text">';
                  echo '<h3 class="card-heading">';
                       the_title(  );
                  echo '</h3>';  
                  echo '<p class="section-item-information">';
                  echo get_post_text_only(get_the_ID(  ));
                    // the_content();
                //   the_excerpt(  );
                  
                  echo '</p> ';
                  echo '<input
                      type="button"
                      value="Add to cart"
                      class="add-cart-btn"
                    />';
                  echo'</div></li>';

                    }
                }
                ?>
                </ul>
            </div>
        </div>
        </section>
<?php 
my_theme_script();   
get_footer();
?>