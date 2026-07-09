<?php
// 1. Carrega o estilo principal do tema de forma profissional
function mudateca_enqueue_styles() {
    wp_enqueue_style( 'mudateca-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mudateca_enqueue_styles' );

// 2. Habilita suporte ao WooCommerce
function mudateca_suporte_woocommerce() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mudateca_suporte_woocommerce');