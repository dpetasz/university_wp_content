<?php get_header();
pageBanner(array(
    // to są instrukcje do sprawdzania czy jesteśmy na kategoriach czy w autorze i jeszcze możemy dodać daty itd
    //  if (is_category()) {
    //     single_cat_title();
    // } elseif (is_author()) {
    //     echo 'Posts by ';
    //     the_author();
    // }
    //aby uniknąć tylu insturkcji możemy użyć do tego tej funkcji, która się zajmie sprawdzeniem tego wszystkiego co robiliśmy wcześniej
    'title' => get_the_archive_title(),
    'subtitle' => get_the_archive_description(), // ta funkcja pobiera aktualny opis w zależności gdzie jesteśmy (autor, kategorie, daty itd.).
))
?>


<div class="container container--narrow page-section">
    <?php while (have_posts()) {
        the_post(); ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y') ?> in <?php echo get_the_category_list(', ') ?></p>
            </div>
            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Kontynyuj czytanie &raquo;</a></p>
            </div>
        </div>
    <?php
}
the_posts_pagination(); ?>
</div>
<?php get_footer(); ?>