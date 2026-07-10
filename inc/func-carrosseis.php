<?php
// ==================================================
// GRADE DE PRODUTOS 
// ==================================================
function mudateca_exibir_grade_produtos( $titulo = 'Produtos', $quantidade = 24 ) {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $quantidade,
        'post_status'    => 'publish',
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        echo '<div class="mudateca-ofertas-section">';
        echo '<div class="mudateca-ofertas-container">';
        echo '<h2 class="mudateca-header-titulo">' . esc_html( $titulo ) . '</h2>';
        echo '<div class="mudateca-grid">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $product = wc_get_product( get_the_ID() );
            $url = get_permalink();
            $title = get_the_title();
            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
            if ( ! $image_url ) {
                $image_url = wc_placeholder_img_src();
            }
            $price_html = $product->get_price_html();
            echo '<a href="' . esc_url( $url ) . '" class="mudateca-produto">';
            echo '<img class="mudateca-produto-img" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" loading="lazy">';
            echo '<h3 class="mudateca-produto-titulo">' . esc_html( $title ) . '</h3>';
            echo '<span class="mudateca-preco-novo">' . wp_kses_post( $price_html ) . '</span>';
            echo '</a>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        wp_reset_postdata();
    }
}

// ==================================================
// CARROSSEL MAIS VISTOS 
// ==================================================
function mudateca_exibir_carrossel_mais_vistos( $titulo = 'Mais Vistos', $link_ver_todos = '#', $quantidade = 8 ) {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $quantidade,
        'post_status'    => 'publish',
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
    );
    $query = new WP_Query( $args );
    $section_id = uniqid('vistos_');
    if ( $query->have_posts() ) {
        ?>
        <div class="vistos-section-wrapper" id="vistos-section-<?php echo esc_attr($section_id); ?>">
          <div class="vistos-flex-container">
            <div class="vistos-right-box">
              <div class="vistos-carousel-header">
                <div class="vistos-header-texts">
                  <h2><?php echo esc_html($titulo); ?></h2>
                  <a href="<?php echo esc_url($link_ver_todos); ?>">Mostrar todos</a>
                </div>
                <div class="vistos-dots-wrapper">
                  <?php 
                  $num_dots = min(5, $query->post_count);
                  for ($i = 0; $i < $num_dots; $i++) {
                      echo '<button class="vistos-dot-item' . ($i === 0 ? ' active' : '') . '"></button>';
                  }
                  ?>
                </div>
              </div>
              <button class="vistos-arrow prev" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
              </button>
              <div class="vistos-track">
                <?php 
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $product = wc_get_product( get_the_ID() );
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: wc_placeholder_img_src();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="vistos-product">
                      <img class="vistos-product-img" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <h3 class="vistos-product-title"><?php the_title(); ?></h3>
                      <?php if ( $product->is_on_sale() ) : ?>
                        <span class="vistos-old-price"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                        <div class="vistos-price-row">
                          <span class="vistos-new-price"><?php echo wc_price( $product->get_sale_price() ); ?></span>
                          <?php 
                            $regular = (float) $product->get_regular_price();
                            $sale    = (float) $product->get_sale_price();
                            $desc    = round( ( ( $regular - $sale ) / $regular ) * 100 );
                          ?>
                          <span class="vistos-discount-tag"><?php echo $desc; ?>% OFF</span>
                        </div>
                      <?php else : ?>
                        <div class="vistos-price-row">
                          <span class="vistos-new-price"><?php echo wc_price( $product->get_price() ); ?></span>
                        </div>
                      <?php endif; ?>
                      <span class="vistos-free-shipping">Frete grátis</span>
                    </a>
                    <?php
                }
                ?>
              </div>
              <button class="vistos-arrow next" aria-label="Próximo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </button>
            </div>
          </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const section = document.getElementById('vistos-section-<?php echo $section_id; ?>');
            if (!section) return;
            const track = section.querySelector('.vistos-track');
            const btnNext = section.querySelector('.vistos-arrow.next');
            const btnPrev = section.querySelector('.vistos-arrow.prev');
            const dots = section.querySelectorAll('.vistos-dot-item');
            const scrollAmount = 430;
            function atualizarSetas() {
              if (!track) return;
              const maxScrollLeft = track.scrollWidth - track.clientWidth;
              if (track.scrollLeft <= 5) {
                if(btnPrev) btnPrev.style.display = 'none';
              } else {
                if(btnPrev) btnPrev.style.display = 'flex';
              }
              if (maxScrollLeft <= 0 || track.scrollLeft >= maxScrollLeft - 5) {
                if(btnNext) btnNext.style.display = 'none';
              } else {
                if(btnNext) btnNext.style.display = 'flex';
              }
            }
            if (btnNext && track) btnNext.addEventListener('click', () => track.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
            if (btnPrev && track) btnPrev.addEventListener('click', () => track.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
            if (track) {
              atualizarSetas();
              track.addEventListener('scroll', function() {
                atualizarSetas();
                if (dots.length > 0) {
                  const maxScrollLeft = track.scrollWidth - track.clientWidth;
                  if (maxScrollLeft <= 0) return;
                  const percentage = track.scrollLeft / maxScrollLeft;
                  const activeIndex = Math.min(Math.round(percentage * (dots.length - 1)), dots.length - 1);
                  dots.forEach((dot, idx) => dot.classList.toggle('active', idx === activeIndex));
                }
              });
              if (dots.length > 0) {
                dots.forEach((dot, index) => {
                  dot.addEventListener('click', () => {
                    const maxScrollLeft = track.scrollWidth - track.clientWidth;
                    const targetScroll = (index / (dots.length - 1)) * maxScrollLeft;
                    track.scrollTo({ left: targetScroll, behavior: 'smooth' });
                  });
                });
              }
            }
          });
        </script>
        <?php
        wp_reset_postdata();
    }
}

// ==================================================
// CARROSSEL NOVIDADES 
// ==================================================
function mudateca_exibir_carrossel_novidades( $titulo = 'Novidades', $link_ver_todos = '#', $quantidade = 8 ) {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $quantidade,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    $query = new WP_Query( $args );
    $section_id = uniqid('novidades_');
    if ( $query->have_posts() ) {
        ?>
        <div class="vistos-section-wrapper" id="novidades-section-<?php echo esc_attr($section_id); ?>">
          <div class="vistos-flex-container">
            <div class="vistos-right-box">
              <div class="vistos-carousel-header">
                <div class="vistos-header-texts">
                  <h2><?php echo esc_html($titulo); ?></h2>
                  <a href="<?php echo esc_url($link_ver_todos); ?>">Mostrar todos</a>
                </div>
                <div class="vistos-dots-wrapper">
                  <?php 
                  $num_dots = min(5, $query->post_count);
                  for ($i = 0; $i < $num_dots; $i++) {
                      echo '<button class="vistos-dot-item' . ($i === 0 ? ' active' : '') . '"></button>';
                  }
                  ?>
                </div>
              </div>
              <button class="vistos-arrow prev" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
              </button>
              <div class="vistos-track">
                <?php 
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $product = wc_get_product( get_the_ID() );
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: wc_placeholder_img_src();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="vistos-product">
                      <img class="vistos-product-img" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <h3 class="vistos-product-title"><?php the_title(); ?></h3>
                      <?php if ( $product->is_on_sale() ) : ?>
                        <span class="vistos-old-price"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                        <div class="vistos-price-row">
                          <span class="vistos-new-price"><?php echo wc_price( $product->get_sale_price() ); ?></span>
                          <?php 
                            $regular = (float) $product->get_regular_price();
                            $sale    = (float) $product->get_sale_price();
                            if ($regular > 0) {
                                $desc = round( ( ( $regular - $sale ) / $regular ) * 100 );
                                echo '<span class="vistos-discount-tag">' . $desc . '% OFF</span>';
                            }
                          ?>
                        </div>
                      <?php else : ?>
                        <div class="vistos-price-row">
                          <span class="vistos-new-price"><?php echo wc_price( $product->get_price() ); ?></span>
                        </div>
                      <?php endif; ?>
                      <span class="vistos-free-shipping">Frete grátis</span>
                    </a>
                    <?php
                }
                ?>
              </div>
              <button class="vistos-arrow next" aria-label="Próximo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </button>
            </div>
          </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const section = document.getElementById('novidades-section-<?php echo $section_id; ?>');
            if (!section) return;
            const track = section.querySelector('.vistos-track');
            const btnNext = section.querySelector('.vistos-arrow.next');
            const btnPrev = section.querySelector('.vistos-arrow.prev');
            const dots = section.querySelectorAll('.vistos-dot-item');
            const scrollAmount = 430;
            function atualizarSetas() {
              if (!track) return;
              const maxScrollLeft = track.scrollWidth - track.clientWidth;
              if (track.scrollLeft <= 5) {
                if(btnPrev) btnPrev.style.display = 'none';
              } else {
                if(btnPrev) btnPrev.style.display = 'flex';
              }
              if (maxScrollLeft <= 0 || track.scrollLeft >= maxScrollLeft - 5) {
                if(btnNext) btnNext.style.display = 'none';
              } else {
                if(btnNext) btnNext.style.display = 'flex';
              }
            }
            if (btnNext && track) btnNext.addEventListener('click', () => track.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
            if (btnPrev && track) btnPrev.addEventListener('click', () => track.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
            if (track) {
              atualizarSetas();
              track.addEventListener('scroll', function() {
                atualizarSetas();
                if (dots.length > 0) {
                  const maxScrollLeft = track.scrollWidth - track.clientWidth;
                  if (maxScrollLeft <= 0) return;
                  const percentage = track.scrollLeft / maxScrollLeft;
                  const activeIndex = Math.min(Math.round(percentage * (dots.length - 1)), dots.length - 1);
                  dots.forEach((dot, idx) => dot.classList.toggle('active', idx === activeIndex));
                }
              });
              if (dots.length > 0) {
                dots.forEach((dot, index) => {
                  dot.addEventListener('click', () => {
                    const maxScrollLeft = track.scrollWidth - track.clientWidth;
                    const targetScroll = (index / (dots.length - 1)) * maxScrollLeft;
                    track.scrollTo({ left: targetScroll, behavior: 'smooth' });
                  });
                });
              }
            }
          });
        </script>
        <?php
        wp_reset_postdata();
    }
}

// ==================================================
// CARROSSEL BLOG 
// ==================================================
function mudateca_exibir_carrossel_blog( $titulo = 'Blog', $link_ver_todos = '/blog', $quantidade = 6 ) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $quantidade,
        'post_status'    => 'publish',
    );
    $query = new WP_Query( $args );
    $section_id = uniqid('blog_');
    if ( $query->have_posts() ) {
        ?>
        <div class="muda-blog-wrapper" id="muda-blog-<?php echo esc_attr($section_id); ?>">
          <div class="muda-blog-container">
            <div class="muda-blog-header">
              <h2><?php echo esc_html($titulo); ?></h2>
              <?php if ( !empty($link_ver_todos) ) : ?>
                <a href="<?php echo esc_url($link_ver_todos); ?>">Ver todos os artigos</a>
              <?php endif; ?>
            </div>
            <div class="muda-blog-carousel">
              <button class="muda-blog-nav prev" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
              </button>
              <div class="muda-blog-track">
                <?php 
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $excerpt = get_the_excerpt();
                    if (empty($excerpt)) {
                        $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 20, '...');
                    } else {
                        $excerpt = wp_trim_words($excerpt, 20, '...');
                    }
                    ?>
                    <a href="<?php the_permalink(); ?>" class="muda-blog-card">
                      <?php if ($image_url) : ?>
                        <img class="muda-blog-image" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <?php else : ?>
                        <div class="muda-blog-image" style="background-color: #eee; display: flex; align-items: center; justify-content: center; color: #999;">Sem imagem</div>
                      <?php endif; ?>
                      <div class="muda-blog-content">
                        <h3 class="muda-blog-title"><?php the_title(); ?></h3>
                        <p class="muda-blog-excerpt"><?php echo esc_html($excerpt); ?></p>
                        <span class="muda-blog-readmore">Ler artigo</span>
                      </div>
                    </a>
                    <?php
                }
                ?>
              </div>
              <button class="muda-blog-nav next" aria-label="Próximo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </button>
            </div>
          </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const section = document.getElementById('muda-blog-<?php echo $section_id; ?>');
            if (!section) return;
            const track = section.querySelector('.muda-blog-track');
            const btnNext = section.querySelector('.muda-blog-nav.next');
            const btnPrev = section.querySelector('.muda-blog-nav.prev');
            if (!track) return;
            function atualizarSetas() {
              const maxScrollLeft = track.scrollWidth - track.clientWidth;
              if (track.scrollLeft <= 5) {
                if(btnPrev) btnPrev.style.display = 'none';
              } else {
                if(btnPrev) btnPrev.style.display = 'flex';
              }
              if (maxScrollLeft <= 0 || track.scrollLeft >= maxScrollLeft - 5) {
                if(btnNext) btnNext.style.display = 'none';
              } else {
                if(btnNext) btnNext.style.display = 'flex';
              }
            }
            if (btnNext) {
              btnNext.addEventListener('click', () => {
                const firstCard = track.querySelector('.muda-blog-card');
                if(firstCard) {
                    const cardWidth = firstCard.clientWidth + 20; 
                    track.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
              });
            }
            if (btnPrev) {
              btnPrev.addEventListener('click', () => {
                const firstCard = track.querySelector('.muda-blog-card');
                if(firstCard) {
                    const cardWidth = firstCard.clientWidth + 20;
                    track.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                }
              });
            }
            track.addEventListener('scroll', atualizarSetas);
            atualizarSetas(); 
          });
        </script>
        <?php
        wp_reset_postdata();
    }
}

// ==================================================
// VITRINE MOSAICO DE PRODUTOS
// ==================================================
function mudateca_exibir_mosaico_produtos( $titulo = 'tênis dos bons até 60% off', $subtitulo = 'é mimo que não acaba mais', $texto_link = 'comprar tudo', $link_url = '/loja', $categoria_slug = '' ) {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 6, 
        'post_status'    => 'publish',
    );
    if ( ! empty( $categoria_slug ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $categoria_slug,
            ),
        );
    }
    $query = new WP_Query( $args );
    $section_id = uniqid('mosaico_');
    if ( $query->have_posts() ) {
        ?>
        <div class="muda-mosaico-section" id="<?php echo esc_attr($section_id); ?>">
          <div class="muda-mosaico-container">
            <div class="muda-mosaico-header">
              <div class="muda-mosaico-titles">
                <h2><?php echo esc_html($titulo); ?></h2>
                <?php if ( !empty($subtitulo) ) : ?>
                  <p class="muda-mosaico-subtitle"><?php echo esc_html($subtitulo); ?></p>
                <?php endif; ?>
              </div>
              <?php if ( !empty($link_url) ) : ?>
                <a href="<?php echo esc_url($link_url); ?>" class="muda-mosaico-link"><?php echo esc_html($texto_link); ?></a>
              <?php endif; ?>
            </div>
            <div class="muda-mosaico-grid">
              <?php 
              while ( $query->have_posts() ) {
                  $query->the_post();
                  $product = wc_get_product( get_the_ID() );
                  $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                  if ( ! $image_url ) {
                      $image_url = wc_placeholder_img_src();
                  }
                  $price = $product->get_price();
                  $regular_price = $product->get_regular_price();
                  $sale_price = $product->get_sale_price();
                  ?>
                  <a href="<?php the_permalink(); ?>" class="muda-mosaico-card">
                    <img class="muda-mosaico-image" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    <div class="muda-mosaico-price-tag">
                      <?php if ( $product->is_on_sale() ) : ?>
                        <span class="muda-mosaico-new-price"><?php echo wc_price( $sale_price ); ?></span>
                        <span class="muda-mosaico-old-price"><?php echo wc_price( $regular_price ); ?></span>
                      <?php else : ?>
                        <span class="muda-mosaico-new-price"><?php echo wc_price( $price ); ?></span>
                      <?php endif; ?>
                    </div>
                  </a>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php
        wp_reset_postdata();
    }
}