<?php 

/**
 * Contains header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset')?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php wp_head(); ?>
    <!-- <link rel="stylesheet" href="/style.css" /> -->
    <title>Pizza web-site</title>
  </head>
  <body  <?php body_class('body');?> >
    <!-- <div class="main-circle"></div>
    <div class="main-circle"></div>
    <div class="main-circle"></div> -->
    
    <header class="header">
        <div class="wrapper test">
        <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" class="logo-img">
        </a>
    </div>
    <button class="menu-toggle" id="menu-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <?php
echo '<div class="nav-div">';
echo '<button class="menu-toggle active" id="menu-toggle1">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>';
if ( has_nav_menu( 'primary' ) ) :
 
    wp_nav_menu( array(
        'theme_location' => 'primary', // Используйте зарегистрированное местоположение
        'container'      => 'nav',     // HTML-элемент-контейнер (например, <nav>)
        'container_class'=> 'navigation',  // Класс для контейнера
        'menu_class'     => 'nav-menu',// Класс для <ul>
        'fallback_cb'    => false,     // Не показывать что-либо, если меню не задано
        'add_span' => true,
    ) );
endif;
echo '</div>';
?>
          <!-- <div class="logo"><img src="/img/logo-light.png" alt="Logo" /></div>
          <nav class="navigation">
            <ul>
              <li><a href="#pizza" class="nav-link">Pizza</a></li>
              <li><a href="#pasta" class="nav-link">Pasta</a></li>
              <li><a href="#">Salad</a></li>
              <li><a href="#">Drinks</a></li>
            </ul>
          </nav> -->
        </div>
       
      </header>
      <div class="container">
      <!-- <header class="header header1">
        <div class="wrapper">
          <div class="logo"><img src="/img/logo-light.png" alt="Logo" /></div>
          <nav class="navigation">
            <ul>
              <li><a href="#pizza">Pizza</a></li>
              <li><a href="#pasta">Pasta</a></li>
              <li><a href="#">Salad</a></li>
              <li><a href="#">Drinks</a></li>
            </ul>
          </nav>
        </div>
      </header> -->
