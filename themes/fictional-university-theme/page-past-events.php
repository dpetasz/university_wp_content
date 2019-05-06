<?php

get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'Podsumowanie naszych wydarzeń z przeszłości.'
))
?>



<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1), //bez tego wpisu paginacja nie działa poprawnie ponieważ wyświetla tylko pierwsze wydarzenie poniewarz nistandardowe zapytanie nie zwraca uwagi na wynik strony (unit36 11' tu jest to wyjaśnione)
        //get_query_var zwraca nam informację o aktualnej stronie url (będzie to dla pierwszej 0 i następnie 2,3,4...), drugi argument jest to domyślna liczba która będzie uzywana jeżeli wordpress nie znajdzie dynamicznie numeru strony.
        // 'posts_per_page' => 1,
        'post_type' => 'event',
        "meta_key" => 'event_date', //tutaj podajemy to pole niestandardowe które stworzyliśmy
        'orderby' => 'meta_value_num', //pożądkowanie niestandardowe gdzie potrzebujemy podać jeszcze z jakiego pola chce kożystać
        'order' => 'ASC',
        //tutaj jest niestandardowe zapytanie które pobiera tylko te dane które spełniają poniższy warunek
        'meta_query' => array(
            array(
                'key' => 'event_date', //dane z niestandardowego pola event_date
                'compare' => '<', //porównanie z 
                'value' => $today, //wartością daty
                'type' => 'numeric' //i na wszelki wypadek podajemy że jest to typ numeryczny
            )
        )
    ));
    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('template-parts/content-event');
    }
    // echo paginate_links(); //TA paginacja działa tylko wtedy gdy wordpress sam wykonuje(domyślne) i aby u nas dzialała paginacja musimy dodać argument
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages //tutaj dajemy naszej paginacki wszystkie informacje które potrzebuje do prawidłowego wyświetlenia
    ));
    ?>
</div>

<?php get_footer();

?>