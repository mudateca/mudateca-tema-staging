<?php get_header(); ?>

<main id="main-content">
    <h1>Olá, este é o conteúdo principal!</h1>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
    
</main>

<?php get_footer(); ?>