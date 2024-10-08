<?php
/**
 * Template part for displaying parts
 */

?>

<article id="post-<?php theID(); ?>">
    <header class="entry-header">
        <?php 
            the_title('<h2 class="entry-title"><a class="entry-link href="'.esc_url(get_permalink()).'"">', '</a></h2>');
        ?>
    </header>

    <?php 
    if (has_post_thumbnail(  )):
        the_post_thumbnail( 'large' );
    endif;
    ?>

    <div class="entry-content">
        <?php the_excerpt(  )?>
    </div>
</article>