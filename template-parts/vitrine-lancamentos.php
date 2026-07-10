<?php
// ==================================================
// VITRINE DE LANÇAMENTOS (GRADE DE PRODUTOS)
// ==================================================
if ( ! class_exists( 'WooCommerce' ) ) return;

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 24,
    'post_status'    => 'publish',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>

    <div class="mudateca-ofertas-section">
        <div class="mudateca-ofertas-container">
            
            <h2 class="mudateca-header-titulo">Lançamentos da Mudateca</h2>

            <div class="mudateca-grid">
                <?php while ( $query->have_posts() ) : $query->the_post();
                    $product = wc_get_product( get_the_ID() );
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: wc_placeholder_img_src();
                    $price_html = $product->get_price_html();
                ?>
                    <a href="<?php the_permalink(); ?>" class="mudateca-produto">
                        <img class="mudateca-produto-img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <h3 class="mudateca-produto-titulo"><?php the_title(); ?></h3>
                        <span class="mudateca-preco-novo"><?php echo wp_kses_post( $price_html ); ?></span>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </div>
    </div>

<?php endif; ?>