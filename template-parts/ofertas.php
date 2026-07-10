<?php
// ==================================================
// SEÇÃO DE OFERTAS (OFERTA DO DIA + CARROSSEL)
// ==================================================
if ( ! class_exists( 'WooCommerce' ) ) return;
?>

<div class="muda-section-wrapper" id="muda-section-ofertas">
  <div class="muda-flex-container">
    
    <!-- Lado Esquerdo: Oferta do Dia -->
    <div class="muda-left-card">
      <h2 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Oferta do dia</h2>
      <?php
      $query_oferta = new WP_Query( array(
          'post_type'      => 'product',
          'posts_per_page' => 1,
          'orderby'        => 'rand',
          'meta_query'     => array( array('key' => '_sale_price', 'value' => 0, 'compare' => '>', 'type' => 'numeric') )
      ));

      if ( $query_oferta->have_posts() ) : while ( $query_oferta->have_posts() ) : $query_oferta->the_post();
          $product = wc_get_product( get_the_ID() );
      ?>
          <a href="<?php the_permalink(); ?>" class="muda-product" style="min-width: auto;">
            <img class="muda-product-img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>">
            <h3 class="muda-product-title"><?php the_title(); ?></h3>
            <div class="muda-price-row">
              <span class="muda-new-price"><?php echo wc_price( $product->get_sale_price() ); ?></span>
              <span class="muda-discount-tag"><?php echo round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100); ?>% OFF</span>
            </div>
            <span class="muda-free-shipping">Frete grátis</span>
          </a>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>

    <!-- Lado Direito: Carrossel de Ofertas -->
    <div class="muda-right-box">
      <div class="muda-carousel-header">
        <div class="muda-header-texts">
          <h2>Ofertas</h2>
          <a href="<?php echo esc_url( home_url( '/loja' ) ); ?>">Mostrar todas</a>
        </div>
        <div class="muda-dots-wrapper"></div>
      </div>
      <button class="muda-arrow prev" aria-label="Anterior"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
      <div class="muda-track">
        <?php
        $query_carrossel = new WP_Query( array(
            'post_type'      => 'product',
            'posts_per_page' => 8,
            'meta_query'     => array( array('key' => '_sale_price', 'value' => 0, 'compare' => '>', 'type' => 'numeric') )
        ));

        if ( $query_carrossel->have_posts() ) : while ( $query_carrossel->have_posts() ) : $query_carrossel->the_post();
            $product = wc_get_product( get_the_ID() );
        ?>
            <a href="<?php the_permalink(); ?>" class="muda-product">
              <img class="muda-product-img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
              <h3 class="muda-product-title"><?php the_title(); ?></h3>
              <span class="muda-new-price"><?php echo wc_price( $product->get_sale_price() ); ?></span>
            </a>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
      <button class="muda-arrow next" aria-label="Próximo"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
    </div>
  </div>
</div>