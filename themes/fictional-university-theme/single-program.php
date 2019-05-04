<?php
get_header();

while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>NIE ZAPOMNIJ ZASTĄPIĆ MNIE PÓŹNIEJ / single-event</p>
            </div>
        </div>
    </div>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title() ?></span></p>
            </div>
            <div class="generic-content"><?php the_content() ?></div>

            <?php

            //powiązani profesorowie
            $relatedProfessors = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'professor',
                'orderby' => 'title', //pożądkowanie niestandardowe gdzie potrzebujemy podać jeszcze z jakiego pola chce kożystać
                'order' => 'ASC',
                'meta_query' => array( //tutaj jest niestandardowe zapytanie które pobiera tylko te dane które spełniają poniższy warunek
                    array(
                        'key' => 'related_programs', //dane z niestandardowego pola related_programs
                        'compare' => 'LIKE', //porównanie takie jak 
                        'value' => '"' . get_the_ID() . '"', //numer bierzącego wpistu i musimy to umieścić w cudzysłowie, a wyjaśnione jest to w unit 38 18 min
                    )
                )

            ));

            if ($relatedProfessors->have_posts()) { //sprawdza czy są powiązani profesorowie
                echo '<hr class="section-break">';
                echo '<h3 class="headline headline--medium">' . get_the_title() . ' Professors</h3>';

                // print_r(get_the_ID());
                // print_r($homepageEvents);//wyświetla zawartość argumentu
                ?>
                <ul class="professor-cards">
                    <?php
                    while ($relatedProfessors->have_posts()) {
                        $relatedProfessors->the_post(); ?>
                        <li class="professor-card__list-item">
                            <a class="professor-card" href="<?php the_permalink(); ?>">
                                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="<?php the_title(); ?>">
                                <span class="professor-card__name"><?php the_title(); ?></span>

                            </a>
                        </li>
                    <?php
                }
                echo '</ul>';
            }

            wp_reset_postdata();
            // the_ID();

            $today = date('Ymd'); //funkcja pobiera dzisiejszą datę
            // echo 'dzisiaj jest:' . $today;
            $homepageEvents = new WP_Query(array(
                'posts_per_page' => 2,
                'post_type' => 'event',
                "meta_key" => 'event_date', //tutaj podajemy to pole niestandardowe które stworzyliśmy
                'orderby' => 'meta_value_num', //pożądkowanie niestandardowe gdzie potrzebujemy podać jeszcze z jakiego pola chce kożystać
                'order' => 'ASC',
                'meta_query' => array( //tutaj jest niestandardowe zapytanie które pobiera tylko te dane które spełniają poniższy warunek
                    array(
                        'key' => 'event_date', //dane z niestandardowego pola event_date
                        'compare' => '>=', //porównanie z 
                        'value' => $today, //wartością daty
                        'type' => 'numeric' //i na wszelki wypadek podajemy że jest to typ numeryczny
                    ),
                    array(
                        'key' => 'related_programs', //dane z niestandardowego pola related_programs
                        'compare' => 'LIKE', //porównanie takie jak 
                        'value' => '"' . get_the_ID() . '"', //numer bierzącego wpistu i musimy to umieścić w cudzysłowie, a wyjaśnione jest to w unit 38 18 min
                    )
                )

            ));

            if ($homepageEvents->have_posts()) { //sprawdza czy są jakieś posty
                echo '<hr class="section-break">';
                echo '<h3 class="headline headline--medium">Upcoming ' . get_the_title() .  ' Events</h3>';

                // print_r(get_the_ID());
                // print_r($homepageEvents);//wyświetla zawartość argumentu
                while ($homepageEvents->have_posts()) {
                    $homepageEvents->the_post();
                    $eventDate = new DateTime(get_field('event_date')); //ustawiamy datę z niestandardowego pola event_date (musimy ustawić format zwracanej daty na d-m-Y H:i:s) czas to zależy czy chcemy
                    // echo $eventDate->format('H:m'); //wyświetlam godzinę dla przykładu
                    ?>
                        <div class="event-summary">
                            <a class="event-summary__date t-center" href="#">
                                <span class="event-summary__month">
                                    <?php

                                    echo $eventDate->format('M');
                                    ?>
                                </span>
                                <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                                <p><?php echo wp_trim_words(get_the_content(), 3) ?><a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
                            </div>
                        </div>
                    <?php
                }
            }
            ?>

        </div>
    </div>

<?php
}

get_footer();
?>