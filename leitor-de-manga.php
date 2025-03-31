<?php
/*
Plugin Name: Leitor de Mangá
Plugin URI: https://seusite.com
Description: Um plugin para exibir mangás com modos de leitura personalizáveis.
Version: 1.0
Author: Seu Nome
Author URI: https://seusite.com
License: GPL2
*/

// Bloquear acesso direto ao arquivo
if (!defined('ABSPATH')) {
    exit;
}

// Registrar Custom Post Type "Mangás"
function lm_registrar_cpt_mangas() {
    $args = array(
        'labels' => array(
            'name' => 'Mangás',
            'singular_name' => 'Mangá'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'thumbnail', 'editor'),
        'menu_icon' => 'dashicons-book',
        'rewrite' => array('slug' => 'manga'), // A URL para Mangás será agora /manga/
    );
    register_post_type('mangas', $args);
}
add_action('init', 'lm_registrar_cpt_mangas');

// Adicionar o botão de alternância para modo claro/escuro no cabeçalho
function lm_adicionar_modo_escuro() {
    ?>
    <button id="modo-toggle" style="position: fixed; top: 10px; right: 10px; z-index: 9999; background: none; border: none; padding: 0; margin: 0; width: 24px; height: 24px;">
        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/mode-icon.png" alt="Modo Claro/Escuro" style="width: 100%; height: 100%;">
    </button>
    <?php
    // Adicionar o botão de alternância de modos de leitura no rodapé
    ?>
    <button id="leitura-toggle" style="position: fixed; bottom: 60px; right: 20px; z-index: 9998; background: none; border: none; padding: 0; margin: 0; width: 24px; height: 24px;">
        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/reading-mode-icon.png" alt="Modo de Leitura" style="width: 100%; height: 100%;">
    </button>
    <?php
}
add_action('wp_footer', 'lm_adicionar_modo_escuro');

// Registrar Custom Post Type "Capítulos" e associá-lo aos Mangás
function lm_registrar_cpt_capitulos() {
    $args = array(
        'labels' => array(
            'name' => 'Capítulos',
            'singular_name' => 'Capítulo'
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-media-document',
        'rewrite' => array('slug' => 'capitulo'), // A URL para Capítulos será agora /capitulo/
    );
    register_post_type('capitulos', $args);
}
add_action('init', 'lm_registrar_cpt_capitulos');

// Criar relacionamento entre Mangás e Capítulos
function lm_adicionar_meta_box() {
    add_meta_box('lm_manga_relacao', 'Relacionar com Mangá', 'lm_manga_relacao_callback', 'capitulos', 'side', 'default');
}
add_action('add_meta_boxes', 'lm_adicionar_meta_box');

function lm_manga_relacao_callback($post) {
    $mangas = get_posts(array('post_type' => 'mangas', 'numberposts' => -1));
    $valor_selecionado = get_post_meta($post->ID, 'lm_manga_relacionado', true);
    echo '<select name="lm_manga_relacionado" style="width: 100%;">';
    echo '<option value="">Selecione um Mangá</option>';
    foreach ($mangas as $manga) {
        $selected = ($manga->ID == $valor_selecionado) ? 'selected' : '';
        echo '<option value="' . $manga->ID . '" ' . $selected . '>' . $manga->post_title . '</option>';
    }
    echo '</select>';
}

function lm_salvar_meta_box($post_id) {
    if (isset($_POST['lm_manga_relacionado'])) {
        update_post_meta($post_id, 'lm_manga_relacionado', sanitize_text_field($_POST['lm_manga_relacionado']));
    }
}
add_action('save_post', 'lm_salvar_meta_box');

// Definir template para Capítulos
function lm_template_capitulos($template) {
    if (is_singular('capitulos')) {
        return plugin_dir_path(__FILE__) . 'templates/single-capitulos.php';
    }
    return $template;
}
add_filter('single_template', 'lm_template_capitulos');

// Carregar o estilo do plugin
function lm_incluir_estilos() {
    wp_enqueue_style('leitor-manga-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'lm_incluir_estilos');

// Carregar o script de alternância de modo escuro/claro
function lm_incluir_scripts() {
    wp_enqueue_script('leitor-manga-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'lm_incluir_scripts');
?>