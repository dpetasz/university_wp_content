<!DOCTYPE html>
<!-- funkcja rozpoznaje jakiego języka używamy  -->
<html <?php language_attributes(); ?>>


<head>
    <!-- dynamicznie określenie tagi -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<!-- funkcja body_class() dodaje atrybuty i wyświetla je w body w zależności na jakiej stronie się znajdujemy(np. id strony itd) -->

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left"><a href='<?php echo site_url()  ?>'><strong>Fictional</strong> University</a></h1>
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">

                    <!-- 
                        <?php
                        // funkcja odpowiada za pobieranie menu z wordpresss, ktorą stworzyliśmy w functions.php nazwa z pierwszego argumentu
                        wp_nav_menu(array(
                            'theme_location' => 'headerMenuLocation',
                        ));
                        ?> -->
                    <ul>
                        <!-- W instrukcji if sprawdzamy czy to jest ta strona lub ta strona ma rodzica o takim id
                    i wtedy przypisujemy klasę odpowiadającą zmianie koloru napisu About us -->
                        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 12) echo 'class = "current-menu-item"' ?>><a href='<?php echo site_url('/about-us')  ?>'>About Us <?php echo wp_get_post_parent_id(0) . wp_get_post_parent_id(get_the_ID())  ?></a></li>
                        <li <?php if (get_post_type() == 'program') echo 'class = "current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
                        <li <?php if (get_post_type() == 'event' || is_page('past-events')) echo 'class = "current-menu-item"' ?>><a href="<?php echo site_url('/event') ?>">Events</a></li>
                        <li <?php if (get_post_type() == 'campus') echo 'class = "current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('campus') ?>">Campuses</a></li>
                        <!-- instrukcja sprawdza czy typem jest post i dodaje klasę aby był kolor aktywnej strony -->
                        <li <?php if (get_post_type() == 'post') echo 'class = "current-menu-item"' ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
                        <!--
                        tutaj sprawdzam jaki jest typ może wyświetlić post lub page i jeżeli stworzymy inne typy to też będziemy mogli tu sprawdzić  
                        <?php echo get_post_type() ?> -->

                    </ul>
                </nav>
                <div class="site-header__util">
                    <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="#" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
                    <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </header>