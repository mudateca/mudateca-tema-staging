<?php
// ==================================================
// 1. BANNERS DA HOME
// ==================================================
function mudateca_registrar_cpt_banners() {
    $args = array(
        'labels' => array(
            'name'               => 'Banners da Home',
            'singular_name'      => 'Banner',
            'menu_name'          => 'Banners',
            'add_new'            => 'Adicionar Novo',
            'add_new_item'       => 'Adicionar Novo Banner',
            'edit_item'          => 'Editar Banner',
            'all_items'          => 'Todos os Banners',
            'trash'              => 'Lixeira'
        ),
        'public'              => false, 
        'show_ui'             => true,  
        'menu_position'       => 20,    
        'menu_icon'           => 'dashicons-images-alt2', 
        'supports'            => array( 'title', 'thumbnail' ), 
    );
    register_post_type( 'mudateca_banner', $args );
}
add_action( 'init', 'mudateca_registrar_cpt_banners' );

// ==================================================
// 2. CARDS DA HOME
// ==================================================
function mudateca_registrar_cpt_cards() {
    register_post_type('mudateca_card', array(
        'labels'      => array(
            'name'          => 'Cards da Home',
            'singular_name' => 'Card',
            'menu_name'     => 'Cards (Home)',
            'all_items'     => 'Todos os Cards',
            'add_new_item'  => 'Adicionar Novo Card',
        ),
        'public'      => false,
        'show_ui'     => true,
        'menu_position'=> 21,
        'menu_icon'   => 'dashicons-grid-view', 
        'supports'    => array('title', 'editor', 'thumbnail'),
    ));
}
add_action('init', 'mudateca_registrar_cpt_cards');

function mudateca_add_card_meta_box() {
    add_meta_box('card_link_meta', 'Configurações do Link', 'mudateca_card_meta_box_html', 'mudateca_card', 'normal', 'default');
}
add_action('add_meta_boxes', 'mudateca_add_card_meta_box');

function mudateca_card_meta_box_html($post) {
    $link_text = get_post_meta($post->ID, '_card_link_text', true);
    $link_url = get_post_meta($post->ID, '_card_link_url', true);
    ?>
    <p>
        <label for="card_link_text"><strong>Texto do Link:</strong> (Ex: Comprar agora)</label><br>
        <input type="text" id="card_link_text" name="card_link_text" value="<?php echo esc_attr($link_text); ?>" style="width:100%; margin-top:5px;" />
    </p>
    <p>
        <label for="card_link_url"><strong>URL de Destino:</strong> (Ex: /colecoes/ofertas)</label><br>
        <input type="url" id="card_link_url" name="card_link_url" value="<?php echo esc_attr($link_url); ?>" style="width:100%; margin-top:5px;" />
    </p>
    <?php
}

function mudateca_save_card_meta($post_id) {
    if (array_key_exists('card_link_text', $_POST)) {
        update_post_meta($post_id, '_card_link_text', sanitize_text_field($_POST['card_link_text']));
    }
    if (array_key_exists('card_link_url', $_POST)) {
        update_post_meta($post_id, '_card_link_url', esc_url_raw($_POST['card_link_url']));
    }
}
add_action('save_post', 'mudateca_save_card_meta');

// ==================================================
// 3. BANNERS DUPLOS
// ==================================================
function mudateca_registrar_cpt_banners_duplos() {
    register_post_type('banner_duplo', array(
        'labels'      => array(
            'name'          => 'Banners Duplos',
            'singular_name' => 'Banner Duplo',
            'add_new_item'  => 'Adicionar Seção de Banners',
        ),
        'public'      => false,
        'show_ui'     => true,
        'menu_position'=> 22,
        'menu_icon'   => 'dashicons-format-gallery',
        'supports'    => array('title'), 
    ));
    register_taxonomy('posicao_banner', 'banner_duplo', array(
        'labels'       => array(
            'name'          => 'Posições no Site',
            'singular_name' => 'Posição',
        ),
        'hierarchical' => true,
        'show_ui'      => true,
    ));
}
add_action('init', 'mudateca_registrar_cpt_banners_duplos');

function mudateca_carregar_media_uploader() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'mudateca_carregar_media_uploader');

function mudateca_add_banner_duplo_meta() {
    add_meta_box('banner_duplo_meta', 'Configurar Banners (Esquerda e Direita)', 'mudateca_banner_duplo_html', 'banner_duplo', 'normal', 'high');
}
add_action('add_meta_boxes', 'mudateca_add_banner_duplo_meta');

function mudateca_banner_duplo_html($post) {
    $img_1 = get_post_meta($post->ID, '_banner_img_1', true);
    $link_1 = get_post_meta($post->ID, '_banner_link_1', true);
    $img_2 = get_post_meta($post->ID, '_banner_img_2', true);
    $link_2 = get_post_meta($post->ID, '_banner_link_2', true);
    ?>
    <style>
        .muda-banner-admin-grid { display: flex; gap: 20px; }
        .muda-banner-admin-col { flex: 1; background: #f9f9f9; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .muda-banner-preview { max-width: 100%; height: auto; margin-top: 10px; border-radius: 4px; display: <?php echo $img_1 ? 'block' : 'none'; ?>; }
    </style>
    <div class="muda-banner-admin-grid">
        <div class="muda-banner-admin-col">
            <h3>Banner da Esquerda</h3>
            <p><label><strong>Link de Destino:</strong></label><br>
            <input type="url" name="banner_link_1" value="<?php echo esc_attr($link_1); ?>" style="width:100%;" /></p>
            <p><label><strong>Imagem:</strong></label><br>
            <input type="hidden" id="banner_img_1_url" name="banner_img_1" value="<?php echo esc_attr($img_1); ?>" />
            <button class="button upload_image_button" data-target="banner_img_1_url" data-preview="preview_img_1">Selecionar Imagem</button>
            <button class="button remove_image_button" data-target="banner_img_1_url" data-preview="preview_img_1">Remover</button></p>
            <img id="preview_img_1" class="muda-banner-preview" src="<?php echo esc_attr($img_1); ?>" style="display: <?php echo $img_1 ? 'block' : 'none'; ?>;" />
        </div>
        <div class="muda-banner-admin-col">
            <h3>Banner da Direita</h3>
            <p><label><strong>Link de Destino:</strong></label><br>
            <input type="url" name="banner_link_2" value="<?php echo esc_attr($link_2); ?>" style="width:100%;" /></p>
            <p><label><strong>Imagem:</strong></label><br>
            <input type="hidden" id="banner_img_2_url" name="banner_img_2" value="<?php echo esc_attr($img_2); ?>" />
            <button class="button upload_image_button" data-target="banner_img_2_url" data-preview="preview_img_2">Selecionar Imagem</button>
            <button class="button remove_image_button" data-target="banner_img_2_url" data-preview="preview_img_2">Remover</button></p>
            <img id="preview_img_2" class="muda-banner-preview" src="<?php echo esc_attr($img_2); ?>" style="display: <?php echo $img_2 ? 'block' : 'none'; ?>;" />
        </div>
    </div>
    <script>
    jQuery(document).ready(function($){
        var custom_uploader;
        $('.upload_image_button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var target_input = $('#' + button.data('target'));
            var target_preview = $('#' + button.data('preview'));
            if (custom_uploader) { 
                custom_uploader.off('select'); 
            } else {
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Escolha a imagem do Banner',
                    button: { text: 'Usar esta imagem' },
                    multiple: false
                });
            }
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                target_input.val(attachment.url);
                target_preview.attr('src', attachment.url).show();
            });
            custom_uploader.open();
        });
        $('.remove_image_button').click(function(e){
            e.preventDefault();
            var button = $(this);
            $('#' + button.data('target')).val('');
            $('#' + button.data('preview')).hide();
        });
    });
    </script>
    <?php
}

function mudateca_save_banner_duplo($post_id) {
    if (isset($_POST['banner_img_1'])) update_post_meta($post_id, '_banner_img_1', esc_url_raw($_POST['banner_img_1']));
    if (isset($_POST['banner_link_1'])) update_post_meta($post_id, '_banner_link_1', esc_url_raw($_POST['banner_link_1']));
    if (isset($_POST['banner_img_2'])) update_post_meta($post_id, '_banner_img_2', esc_url_raw($_POST['banner_img_2']));
    if (isset($_POST['banner_link_2'])) update_post_meta($post_id, '_banner_link_2', esc_url_raw($_POST['banner_link_2']));
}
add_action('save_post', 'mudateca_save_banner_duplo');

function exibir_banners_duplos( $slug_posicao ) {
    $args = array(
        'post_type'      => 'banner_duplo',
        'posts_per_page' => 1, 
        'tax_query'      => array(
            array('taxonomy' => 'posicao_banner', 'field' => 'slug', 'terms' => $slug_posicao)
        ),
    );
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        echo '<div class="banners-duplos-section">';
        echo '<div class="banners-duplos-container">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $img_1 = get_post_meta(get_the_ID(), '_banner_img_1', true);
            $link_1 = get_post_meta(get_the_ID(), '_banner_link_1', true) ?: '#';
            $img_2 = get_post_meta(get_the_ID(), '_banner_img_2', true);
            $link_2 = get_post_meta(get_the_ID(), '_banner_link_2', true) ?: '#';
            if ($img_1) {
                echo '<div class="banner-item"><a href="' . esc_url($link_1) . '"><img src="' . esc_url($img_1) . '" width="547" height="130" alt="Banner Esquerda"></a></div>';
            }
            if ($img_2) {
                echo '<div class="banner-item"><a href="' . esc_url($link_2) . '"><img src="' . esc_url($img_2) . '" width="547" height="130" alt="Banner Direita"></a></div>';
            }
        }
        echo '</div>';
        echo '</div>';
        wp_reset_postdata();
    }
}

// ==================================================
// 4. HERO PROMOCIONAL
// ==================================================
function mudateca_registrar_cpt_hero() {
    register_post_type('mudateca_hero', array(
        'labels'      => array(
            'name'          => 'Hero Promocional',
            'singular_name' => 'Slide do Hero',
            'add_new_item'  => 'Adicionar Novo Slide',
        ),
        'public'      => false,
        'show_ui'     => true,
        'menu_position'=> 21,
        'menu_icon'   => 'dashicons-images-alt2', 
        'supports'    => array('title', 'thumbnail'), 
    ));
}
add_action('init', 'mudateca_registrar_cpt_hero');

function mudateca_add_hero_link_meta() {
    add_meta_box('hero_link_meta', 'Configuração do Slide', 'mudateca_hero_link_html', 'mudateca_hero', 'normal', 'default');
}
add_action('add_meta_boxes', 'mudateca_add_hero_link_meta');

function mudateca_hero_link_html($post) {
    $link_url = get_post_meta($post->ID, '_hero_link_url', true);
    ?>
    <label for="hero_link_url"><strong>Link de Destino ao clicar no Banner:</strong></label><br>
    <input type="url" id="hero_link_url" name="hero_link_url" value="<?php echo esc_attr($link_url); ?>" style="width:100%; margin-top:5px;" placeholder="https://" />
    <?php
}

function mudateca_save_hero_link($post_id) {
    if (array_key_exists('hero_link_url', $_POST)) {
        update_post_meta($post_id, '_hero_link_url', esc_url_raw($_POST['hero_link_url']));
    }
}
add_action('save_post', 'mudateca_save_hero_link');

function mudateca_exibir_hero_promocional() {
    $args = array(
        'post_type'      => 'mudateca_hero',
        'posts_per_page' => -1, 
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC'
    );
    $query = new WP_Query( $args );
    $section_id = uniqid('hero_'); 
    if ( $query->have_posts() ) {
        ?>
        <div class="muda-hero-section" id="hero-promocional-<?php echo esc_attr($section_id); ?>">
          <div class="muda-hero-container">
            <div class="muda-hero-track">
              <?php 
              $count = 0;
              while ( $query->have_posts() ) {
                  $query->the_post();
                  $count++;
                  $link = get_post_meta(get_the_ID(), '_hero_link_url', true) ?: '#';
                  $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                  $alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: 'Banner Promocional';
                  $loading = ($count === 1) ? 'eager' : 'lazy';
                  ?>
                  <div class="muda-hero-slide">
                    <a href="<?php echo esc_url($link); ?>">
                      <?php if ($img_url) : ?>
                        <img class="muda-hero-image" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="<?php echo $loading; ?>">
                      <?php else : ?>
                        <div style="width: 100%; height: 300px; background-color: #FF914D; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold;">
                          Selecione uma Imagem Destacada no painel
                        </div>
                      <?php endif; ?>
                    </a>
                  </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php
        wp_reset_postdata();
    }
}