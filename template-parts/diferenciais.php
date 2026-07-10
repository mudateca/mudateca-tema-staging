<?php
// ==================================================
// SEÇÃO DE DIFERENCIAIS DA LOJA
// ==================================================

// Definimos o array de diferenciais aqui ou podemos passar via variável global se necessário
$diferenciais = array(
    array(
        'icone_svg'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3483FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
        'titulo'     => 'Escolha como pagar',
        'texto'      => 'Com Mercado Pago, você paga com cartão, boleto ou Pix.',
        'link_texto' => 'Como pagar com Mercado Pago',
        'link_url'   => '#'
    ),
    array(
        'icone_svg'  => '<svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#3483FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>',
        'titulo'     => 'Frete grátis',
        'texto'      => 'Aproveite este benefício em milhões de produtos.',
        'link_texto' => 'Ver condições',
        'link_url'   => '#'
    ),
    array(
        'icone_svg'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3483FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>',
        'titulo'     => 'Segurança, do início ao fim',
        'texto'      => 'Você não gostou do que comprou? Devolva! Você está sempre protegido.',
        'link_texto' => 'Como te protegemos',
        'link_url'   => '#'
    )
);

$section_id = uniqid('diferenciais_');
?>

<div class="muda-diferenciais-section" id="<?php echo esc_attr($section_id); ?>">
  <div class="muda-diferenciais-container">
    <?php foreach ( $diferenciais as $item ) : ?>
      <div class="muda-diferenciais-item">
        <div class="muda-diferenciais-icon">
          <?php if ( ! empty( $item['icone_svg'] ) ) : ?>
            <?php echo $item['icone_svg']; ?>
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