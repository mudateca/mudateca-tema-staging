<?php
// ==================================================
// SEÇÃO HERO (SLIDER DE BANNERS)
// ==================================================
$args_banners = array(
    'post_type'      => 'mudateca_banner', 
    'posts_per_page' => 10,              
    'post_status'    => 'publish',         
    'orderby'        => 'date',            
    'order'          => 'DESC'    
);
$query_banners = new WP_Query( $args_banners );

if ( $query_banners->have_posts() ) : ?>

<section class="hero-wrapper">
  <div class="hero__container">
    
    <div class="hero__media-grid">
      <?php while ( $query_banners->have_posts() ) : $query_banners->the_post();
          if ( has_post_thumbnail() ) :
              $imagem_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
      ?>
              <div class="muda-hero-slide">
                <img src="<?php echo esc_url($imagem_url); ?>" alt="<?php the_title_attribute(); ?>" class="hero__media">
              </div>
      <?php
          endif;
      endwhile;
      wp_reset_postdata(); 
      ?>
    </div>

    <div class="hero-mudateca-pagination"></div>
    
    <button class="hero-mudateca-nav prev" aria-label="Anterior">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"></polyline>
      </svg>
    </button>
    <button class="hero-mudateca-nav next" aria-label="Próximo">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="9 18 15 12 9 6"></polyline>
      </svg>
    </button>

  </div>
</section>

<?php endif; ?>