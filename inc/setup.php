<?php
// 1. Carrega o estilo principal do tema
function mudateca_enqueue_styles() {
    wp_enqueue_style( 'mudateca-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mudateca_enqueue_styles' );

// 2. Habilita suporte ao WooCommerce
function mudateca_suporte_woocommerce() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mudateca_suporte_woocommerce');

// 3. Registra menus
function registrar_meu_menu() {
  register_nav_menu('primary', 'Menu Principal do Topo');
  register_nav_menu('footer-policies', 'Links do Rodapé (Políticas)');
}
add_action('after_setup_theme', 'registrar_meu_menu');

// 4. Habilita o suporte a Imagens Destacadas
add_theme_support( 'post-thumbnails' );