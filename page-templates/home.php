<?php 
/*
Template Name: Home Principal
*/
get_header(); 
?>

<main id="primary" class="site-main">

    <?php 
    // Hero (Banner Principal)
    get_template_part( 'template-parts/hero' ); 
    
    //  Cards Sobrepostos (Menu de categorias rápidas)
    get_template_part( 'template-parts/cards' ); 

    // Adicione esta linha abaixo:
    // 4.1 Seção de Ofertas (Oferta do Dia + Carrossel)
    get_template_part( 'template-parts/ofertas' ); 
    
    // Banner Duplo (Meio da página)
    echo '<div class="container">';
    exibir_banners_duplos('meio-perto-ofertas-dia'); 
    echo '</div>';

    // Grade de Produtos (Lançamentos)
    get_template_part( 'template-parts/vitrine-lancamentos' );

    // 5. Banner Duplo (Abaixo dos produtos)
    echo '<div class="container">';
    exibir_banners_duplos('abaixo-dos-produtos'); 
    echo '</div>';

    // 6. Carrossel Mais Vistos
    mudateca_exibir_carrossel_mais_vistos('mais vistos', '/loja', 10);

    // 7. Banner Duplo (Abaixo dos mais vistos)
    echo '<div class="container">';
    exibir_banners_duplos('abaixo-mais-vistos'); 
    echo '</div>';

    // 8. Carrossel Novidades
    mudateca_exibir_carrossel_novidades('novidades', '/loja', 10);

    // 9. Hero Promocional Adicional
    mudateca_exibir_hero_promocional();

    // 10. Blog
    get_template_part( 'template-parts/blog' );

    // 11. Mosaico de Vintage
    mudateca_exibir_mosaico_produtos(
        'achados vintage incríveis', 
        'peças únicas escolhidas a dedo', 
        'ver coleção completa', 
        '/loja'
    );

    // 12. Newsletter
    get_template_part( 'template-parts/newsletter' );

    // 13. Diferenciais
    get_template_part( 'template-parts/diferenciais' );
    ?>

</main>

<?php get_footer(); ?>