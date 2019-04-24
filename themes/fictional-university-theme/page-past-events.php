<?php

get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">
            <p>Podsumowanie naszych wydarzeń z przeszłości.</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    $today = date('dmY');
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1), //bez tego wpisu paginacja nie działa poprawnie ponieważ wyświetla tylko pierwsze wydarzenie poniewarz nistandardowe zapytanie nie zwraca uwagi na wynik strony (unit36 11' tu jest to wyjaśnione)
        //get_query_var zwraca nam informację o aktualnej stronie url (będzie to dla pierwszej 0 i następnie 2,3,4...), drugi argument jest to domyślna liczba która będzie uzywana jeżeli wordpress nie znajdzie dynamicznie numeru strony.
        // 'posts_per_page' => 1,
        'post_type' => 'event',
        'orderby' => 'meta_value_num', //pożądkowanie niestandardowe gdzie potrzebujemy podać jeszcze z jakiego pola chce kożystać
        "meta_key" => 'event_date', //tutaj podajemy to pole niestandardowe które stworzyliśmy
        'order' => 'ASC',
        'meta_query' => array( //tutaj jest niestandardowe zapytanie które pobiera tylko te dane które spełniają poniższy warunek
            'key' => 'event_date', //dane z niestandardowego pola event_date
            'compare' => '<', //porównanie z 
            'value' => $today, //wartością daty
            'type' => 'numeric' //i na wszelki wypadek podajemy że jest to typ numeryczny
        )

    ));
    while ($pastEvents->have_posts()) {
        $pastEvents->the_post(); ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                    <?php
                    $eventDate = new DateTime(get_field('event_date'));
                    echo $eventDate->format('M')
                    ?></span>
                <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>

            </div>
        </div>
    <?php }
// echo paginate_links(); //TA paginacja działa tylko wtedy gdy wordpress sam wykonuje(domyślne) i aby u nas dzialała paginacja musimy dodać argument
echo paginate_links(array(
    'total' => $pastEvents->max_num_pages //tutaj dajemy naszej paginacki wszystkie informacje które potrzebuje do prawidłowego wyświetlenia
));
?>
</div>

<?php get_footer();

?>