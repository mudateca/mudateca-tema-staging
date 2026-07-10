<?php
// functions.php - O orquestrador do tema

// 1. Configurações básicas e menus
require get_template_directory() . '/inc/setup.php';

// 2. Custom Post Types e Banners
require get_template_directory() . '/inc/cpt-banners.php';

// 3. Funções de Carrosséis e Vitrines
require get_template_directory() . '/inc/func-carrosseis.php';

// 4. Seções Estáticas (Newsletter, Diferenciais)
require get_template_directory() . '/inc/func-secoes.php';