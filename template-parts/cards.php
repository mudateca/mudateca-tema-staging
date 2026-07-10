<?php
// ==================================================
// SEÇÃO DE CARDS SOBREPOSTOS
// ==================================================
$args_cards = array(
    'post_type'      => 'mudateca_card',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC'
);
$query_cards = new WP_Query( $args_cards );

if ( $query_cards->have_posts() ) : ?>

<div class="mudateca-cards-wrapper">
  <div class="mudateca-cards-container">
    
    <?php while ( $query_cards->have_posts() ) : $query_cards->the_post();
        // Puxa os dados dos campos customizados
        $link_text = get_post_meta( get_the_ID(), '_card_link_text', true );
        $link_url  = get_post_meta( get_the_ID(), '_card_link_url', true ) ?: '#';
    ?>
    
      <a href="<?php echo esc_url($link_url); ?>" class="mudateca-card">
        
        <h3 class="mudateca-card-title"><?php the_title(); ?></h3>
        
        <div class="mudateca-card-image">
          <?php if ( has_post_thumbnail() ) : ?>
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
          <?php else : ?>
            <div style="width: 60px; height: 60px; background-color: #F2F2F2; border-radius: 50%;"></div>
          <?php endif; ?>
        </div>
        
        <div class="mudateca-card-text">
          <p><?php echo wp_trim_words( wp_strip_all_tags(get_the_content()), 15, '...' ); ?></p>
        </div>

        <?php if ( !empty($link_text) ) : ?>
          <span class="mudateca-card-link"><?php echo esc_html($link_text); ?></span>
        <?php endif; ?>
        
      </a>

    <?php endwhile; wp_reset_postdata(); ?>

  </div>
</div>

<?php endif; ?>