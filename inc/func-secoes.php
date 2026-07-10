<?php
// ==================================================
// SEÇÃO DE NEWSLETTER
// ==================================================
function mudateca_exibir_newsletter( $titulo = 'Inscreva-se na nossa newsletter', $subtitulo = 'Receba ofertas exclusivas, novidades e muito mais direto no seu e-mail.', $placeholder = 'Seu melhor e-mail', $texto_botao = 'Inscrever' ) {
    $section_id = uniqid('news_');
    ?>
    <div class="muda-news-section" id="<?php echo esc_attr($section_id); ?>">
      <div class="muda-news-container">
        <div class="muda-news-box">
          <div class="muda-news-content">
            <h2><?php echo esc_html($titulo); ?></h2>
            <p><?php echo esc_html($subtitulo); ?></p>
          </div>
          <div class="muda-news-form-wrapper">
            <form action="#" method="POST" class="muda-newsletter-form">
              <div class="muda-input-group">
                <input type="email" name="email_newsletter" class="muda-news-input" placeholder="<?php echo esc_attr($placeholder); ?>" required>
                <button type="submit" class="muda-news-btn"><?php echo esc_html($texto_botao); ?></button>
              </div>
              <div class="muda-news-message" style="display: none;"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
}

// ==================================================
// SEÇÃO DE DIFERENCIAIS DA LOJA (COM SUPORTE A SVG)
// ==================================================
function mudateca_exibir_diferenciais( $diferenciais = array() ) {
    if ( empty( $diferenciais ) ) return;
    $section_id = uniqid('diferenciais_');
    ?>
    <div class="muda-diferenciais-section" id="<?php echo esc_attr($section_id); ?>">
      <div class="muda-diferenciais-container">
        <?php foreach ( $diferenciais as $item ) : ?>
          <div class="muda-diferenciais-item">
            <div class="muda-diferenciais-icon">
              <?php if ( ! empty( $item['icone_svg'] ) ) : ?>
                <?php echo $item['icone_svg']; ?>
              <?php elseif ( ! empty( $item['icone_url'] ) ) : ?>
                <img src="<?php echo esc_url( $item['icone_url'] ); ?>" alt="<?php echo esc_attr( $item['titulo'] ); ?>" loading="lazy">
              <?php else : ?>
                <div class="muda-icon-placeholder">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </div>
              <?php endif; ?>
            </div>
            <h3><?php echo esc_html( $item['titulo'] ); ?></h3>
            <p><?php echo esc_html( $item['texto'] ); ?></p>
            <?php if ( ! empty( $item['link_texto'] ) && ! empty( $item['link_url'] ) ) : ?>
              <a href="<?php echo esc_url( $item['link_url'] ); ?>" class="muda-diferenciais-link">
                <?php echo esc_html( $item['link_texto'] ); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
}