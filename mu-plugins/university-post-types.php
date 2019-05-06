<?php
function university_post_types()
{
    // campus post type
    register_post_type('campus', array(
        'supports' => array('title', 'editor', 'excerpt'), //, 'custom-fields' - służy do dodawania niestandardowych pól, ale my będziemy używac wtyczki ACF i musimy usunąć to z tablicy
        'rewrite' => array('slug' => 'campuses'), //zmienia nam domyślną ścieżkę url i możemy decydować jaki napis będzie widniał (u nas będzie to : http://localhost/university/wydarzenia/jakieś-wydarzenie-które-sobie-dodamy/)
        'has_archive' => true, //parametr, który wiąże się z archiwum tego postu
        'public' => true, //dzięki temu parametrowi będziemy go widzieli w administratorze wordpressa
        'labels' => array( //etykity w których możemy dodać nazwę typu (jeżeli tego nie zrobimy to nazwa domyślna będzie "Wpisy" )
            'name' => 'Campuses',
            'add_new_item' => 'Dodaj nowy Campus', //to nam daje wyświetlenie w tytule gdy dodajemy nowe wydarzenie
            'edit_item' => 'Edytuj Campus', //gdy wejdziemy do utworzonego wydarzenia to będziemy widzieć ten tytuł
            'all_items' => 'Wszystkie Campuses', //na pasku zmienia domyślne Wydarzenia na to co podajemy
            'singular_name' => 'Campus',
        ),
        'menu_icon' => 'dashicons-location-alt' //dodajemy nową ikonę aby się rozrużniało nasze wydarzenie
    ));


    // event post type
    //    pierwszy argument funkcji to nazwa dla nowego typu
    // drugi argument to tablica różnych opcji które opisują niestandardowy post
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'), //, 'custom-fields' - służy do dodawania niestandardowych pól, ale my będziemy używac wtyczki ACF i musimy usunąć to z tablicy
        'rewrite' => array('slug' => 'event'), //zmienia nam domyślną ścieżkę url i możemy decydować jaki napis będzie widniał (u nas będzie to : http://localhost/university/wydarzenia/jakieś-wydarzenie-które-sobie-dodamy/)
        'has_archive' => true, //parametr, który wiąże się z archiwum tego postu
        'public' => true, //dzięki temu parametrowi będziemy go widzieli w administratorze wordpressa
        'labels' => array( //etykity w których możemy dodać nazwę typu (jeżeli tego nie zrobimy to nazwa domyślna będzie "Wpisy" )
            'name' => 'Wydarzenia',
            'add_new_item' => 'Dodaj nowe wydarzenie', //to nam daje wyświetlenie w tytule gdy dodajemy nowe wydarzenie
            'edit_item' => 'Edytuj wydarzenie', //gdy wejdziemy do utworzonego wydarzenia to będziemy widzieć ten tytuł
            'all_items' => 'Wszystkie wydarzenia', //na pasku zmienia domyślne Wydarzenia na to co podajemy
            'singular_name' => 'Wydarzenie',
        ),
        'menu_icon' => 'dashicons-grid-view' //dodajemy nową ikonę aby się rozrużniało nasze wydarzenie
    ));

    //program post type
    register_post_type('program', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Programy',
            'add_new_item' => 'Dodaj nowy program',
            'edit_item' => 'Edytuj program',
            'all_items' => 'Wszystkie programy',
            'singular_name' => 'Program',
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    //professor post type
    register_post_type('professor', array(
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'Professor',
            'add_new_item' => 'Dodaj nowego profesora',
            'edit_item' => 'Edytuj profesora',
            'all_items' => 'Wszyscy profesorowie',
            'singular_name' => 'Professor',
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));
}
// hak o nazwie init daje nam możliwość dodania nowego typu postu, drugi argument to funkcja, której nazwa jest dowolna ale niech ma jakiś sens
add_action('init', 'university_post_types');
