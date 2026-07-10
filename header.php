<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="mudateca-header">
  <div class="mudateca-container">
    
    <div class="mudateca-row">
      <!-- Logo Dinâmica -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mudateca-logo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="<?php bloginfo('name'); ?>" style="max-width: 120px;">
      </a>

      <!-- Busca -->
      <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="mudateca-search">
        <input type="text" name="s" placeholder="Buscar produtos...">
        <button type="submit">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>
      </form>

      <div style="font-size: 14px; font-weight: 400; display: flex; align-items: center; gap: 6px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 9-6 6"></path><path d="M9 9h.01"></path><path d="M15 15h.01"></path>
            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path>
        </svg>
        Ofertas por tempo limitado
      </div>
    </div>

    <div class="mudateca-row" style="margin-top: 5px;">
      <div style="display: flex; align-items: center; gap: 5px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        <div style="line-height: 1.2; font-size: 12px;">
          <span style="display: block; color: #111928;">Enviar para</span>
          <strong>CEP</strong>
        </div>
      </div>

      <nav class="mudateca-nav">
    <?php 
        wp_nav_menu( array(
            'theme_location' => 'primary', // Isso chama o menu que você criou no painel
            'container'      => false,
            'menu_class'     => 'mudateca-nav-lista'
        )); 
    ?>
</nav>

     

      <div class="mudateca-account">
    <nav class="mudateca-nav-icones">
        <a href="<?php echo wc_get_cart_url(); ?>" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FF8A4C" stroke-width="2">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
        </a>
    </nav>
    <a href="<?php echo wp_registration_url(); ?>">Crie sua conta</a>
    <a href="<?php echo wp_login_url(); ?>" class="btn-entre">Entre</a>
</div>
    </div>
  </div>
</div>