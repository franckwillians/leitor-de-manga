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

// Registrar Custom Post Type "Mangas"
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
    );
    register_post_type('mangas', $args);
}
add_action('init', 'lm_registrar_cpt_mangas');

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
        'rewrite' => array('slug' => 'capitulo'),
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
