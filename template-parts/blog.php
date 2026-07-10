<?php
// Busca os artigos nativos do WordPress
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
);
$query = new WP_Query( $args );
$section_id = uniqid('blog_');

if ( $query->have_posts() ) : ?>
    <div class="muda-blog-wrapper" id="muda-blog-<?php echo esc_attr($section_id); ?>">
      <div class="muda-blog-container">
        
        <div class="muda-blog-header">
          <h2>Últimos Artigos</h2>
          <a href="<?php echo esc_url(home_url('/blog')); ?>">Ver todos os artigos</a>
        </div>

        <div class="muda-blog-carousel">
          <button class="muda-blog-nav prev" aria-label="Anterior">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
          </button>

          <div class="muda-blog-track">
            <?php while ( $query->have_posts() ) : $query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $excerpt = wp_trim_words(wp_strip_all_tags(get_the_excerpt() ?: get_the_content()), 20, '...');
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
            <?php endwhile; wp_reset_postdata(); ?>
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
        
        function atualizarSetas() {
            if (!track) return;
            const maxScrollLeft = track.scrollWidth - track.clientWidth;
            btnPrev.style.display = (track.scrollLeft <= 5) ? 'none' : 'flex';
            btnNext.style.display = (maxScrollLeft <= 0 || track.scrollLeft >= maxScrollLeft - 5) ? 'none' : 'flex';
        }

        if (btnNext) btnNext.addEventListener('click', () => track.scrollBy({ left: track.querySelector('.muda-blog-card').clientWidth + 20, behavior: 'smooth' }));
        if (btnPrev) btnPrev.addEventListener('click', () => track.scrollBy({ left: -(track.querySelector('.muda-blog-card').clientWidth + 20), behavior: 'smooth' }));
        
        track.addEventListener('scroll', atualizarSetas);
        atualizarSetas(); 
      });
    </script>
<?php endif; ?>