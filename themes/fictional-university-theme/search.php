<?php

get_header();
pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false))  . '&rdquo;' //getsearchquery (pobiera to co szukamy) z folsem uniemożliwi komuś wsadzenie złośliwego kodu
));
?>

<div class="container container--narrow page-section">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', get_post_type());//unit 73 10min tu jest dobrze wyjaśnione
        }
        echo paginate_links();
    } else {
        echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
    }

    get_search_form();

    ?>

</div>

<?php get_footer();

?>