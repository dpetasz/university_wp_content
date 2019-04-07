<?php
function university_post_types()
{
    //    pierwszy argument funkcji to nazwa dla nowego typu
    // drugi argument to tablica różnych opcji które opisują niestandardowy post
    register_post_type('event', array(
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
}
// hak o nazwie init daje nam możliwość dodania nowego typu postu, drugi argument to funkcja, której nazwa jest dowolna ale niech ma jakiś sens
add_action('init', 'university_post_types');
