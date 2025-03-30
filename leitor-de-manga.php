<?php
/*
Plugin Name: Leitor de Mangá
Plugin URI: https://seusite.com
Description: Um plugin para exibir mangás com modos de leitura personalizáveis.
Version: 1.0
Author: Franck Willian
Author URI: https://manga.aquitem.info
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
