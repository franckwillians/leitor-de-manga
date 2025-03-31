<?php
/*
Template Name: Home
*/

get_header();

// Consultar os posts de Mangás e Animes
$args = array(
    'post_type' => array('mangas', 'animes'),
    'posts_per_page' => -1,
);

$titulos = new WP_Query($args);
?>

<div class="filtros">
    <label for="filtro-tipo">Filtrar por Tipo:</label>
    <select id="filtro-tipo">
        <option value="todos">Todos os Títulos</option>
        <option value="mangas">Somente Mangás</option>
        <option value="animes">Somente Animes</option>
    </select>
    
    <label for="filtro-data">Filtrar por Data:</label>
    <input type="date" id="filtro-data">
</div>

<div class="grid-titulos">
    <?php if ($titulos->have_posts()) : ?>
        <?php while ($titulos->have_posts()) : $titulos->the_post(); ?>
            <div class="titulo-item">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Nenhum título encontrado</p>
    <?php endif; ?>
</div>

<?php
get_footer();
?>