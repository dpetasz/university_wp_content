<?php
get_header();

while (have_posts()) {
    the_post();
    pageBanner();
    ?>

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title() ?></span></p>
            </div>
            <div class="generic-content"><?php the_content() ?></div>
            <div class="acf-map">
                <?php
                $mapLocation = get_field('map_location');
                ?>

                <div class="marker" data-lat='<?php echo $mapLocation['lat'] ?>' data-lng='<?php echo $mapLocation['lng'] ?>'>
                    <h3><?php the_title() ?></h3>
                    <?php echo $mapLocation['address'] ?>
                    <!-- wczytuje adres na mapie -->
                </div>

            </div>

            <?php

            //powiązani profesorowie
            $relatedPrograms = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'program',
                'orderby' => 'title', //pożądkowanie niestandardowe gdzie potrzebujemy podać jeszcze z jakiego pola chce kożystać
                'order' => 'ASC',
                'meta_query' => array( //tutaj jest niestandardowe zapytanie które pobiera tylko te dane które spełniają poniższy warunek
                    array(
                        'key' => 'related_campus', //dane z niestandardowego pola related_programs
                        'compare' => 'LIKE', //porównanie takie jak 
                        'value' => '"' . get_the_ID() . '"', //numer bierzącego wpistu i musimy to umieścić w cudzysłowie, a wyjaśnione jest to w unit 38 18 min
                    )
                )

            ));

            if ($relatedPrograms->have_posts()) { //sprawdza czy są powiązani profesorowie
                echo '<hr class="section-break">';
                echo '<h2class="headline headline--medium">Programs Available At This Campus</h2>';

                ?>
                <ul class="min-list link-list">
                    <?php
                    while ($relatedPrograms->have_posts()) {
                        $relatedPrograms->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php
                }
                echo '</ul>';
            }

            wp_reset_postdata();
            // the_ID();


            ?>

        </div>
    </div>

<?php
}

get_footer();
?>