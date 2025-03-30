<?php
get_header(); 

// Pegando o ID do capítulo e do mangá associado
$capitulo_id = get_the_ID();
$manga_id = get_post_meta($capitulo_id, 'lm_manga_relacionado', true);

// Pegando os capítulos desse mangá
$capitulos = get_posts(array(
    'post_type' => 'capitulos',
    'meta_key' => 'lm_manga_relacionado',
    'meta_value' => $manga_id,
    'orderby' => 'date',
    'order' => 'ASC'
));

if ($capitulos) {
    $capitulos_ids = wp_list_pluck($capitulos, 'ID');
    $posicao = array_search($capitulo_id, $capitulos_ids);

    $anterior = ($posicao > 0) ? get_permalink($capitulos_ids[$posicao - 1]) : '#';
    $proximo = ($posicao < count($capitulos_ids) - 1) ? get_permalink($capitulos_ids[$posicao + 1]) : '#';
}

?>

<div class="leitor-manga">
    <h1><?php the_title(); ?></h1>
    
    <div class="conteudo-manga">
        <?php the_content(); ?>
    </div>

    <div class="navegacao-manga">
        <a href="<?php echo $anterior; ?>" class="botao-manga">← Capítulo Anterior</a>
        <a href="<?php echo $proximo; ?>" class="botao-manga">Próximo Capítulo →</a>
    </div>
</div>

<style>
    .leitor-manga { text-align: center; max-width: 800px; margin: auto; }
    .conteudo-manga img { width: 100%; height: auto; }
    .navegacao-manga { margin-top: 20px; display: flex; justify-content: space-between; }
    .botao-manga { text-decoration: none; background: #333; color: white; padding: 10px 20px; border-radius: 5px; }
    .botao-manga:hover { background: #555; }
</style>

<?php get_footer(); ?>
