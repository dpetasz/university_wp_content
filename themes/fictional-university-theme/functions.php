<?php
function pageBanner($args = null)
{
  if (!$args['title']) {
    $args['title'] = get_the_title();
  }
  if (!$args['subtitle']) {
    $args['subtitle'] = get_field('podtytul_banera_strony');
  }
  if (!$args['photo']) {
    if (get_field('obraz_banner_background_strony')) {
      $args['photo'] = get_field('obraz_banner_background_strony')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
  ?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url( 
                                                                          <?php
                                                                          // $pageBannerImage = get_field('obraz_banner_background_strony');
                                                                          // echo $pageBannerImage['url'];
                                                                          // echo $pageBannerImage['sizes']['pageBanner'];
                                                                          // echo get_field('obraz_banner_background_strony')['sizes']['pageBanner'];
                                                                          echo $args['photo'];
                                                                          ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>
  </div>
<?php
}
function university_files()
{
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCCBXTbyy5VZ8aYg8moYRVWNWpGnfXf8_U', NULL, '1.0', true);
  wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);


  wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesom', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('styleCSS', get_stylesheet_uri(), null, microtime());
}
add_action('wp_enqueue_scripts', 'university_files');

// dodanie tytułu na pasku strony
function university_features()
{
  // Dodawanie dynamicznego menu
  // register_nav_menu('footerMenuExploreLocation', 'Menu Footer Explore');
  // register_nav_menu('footerMenuLearnLocation', 'Menu Footer Learn');
  // register_nav_menu('headerMenuLocation', 'Menu Header');

  add_theme_support('title-tag'); //dodaje aktualny (dynamicznie) tytuł nagłówka strony
  add_theme_support('post-thumbnails'); //dodawanie obrazków
  add_image_size('professorLandscape', 400, 260, true); //dodajemy nowe wymiary(1.nazwa 2.szerokość 3. wysokość 4.czy przyciąć)
  add_image_size('professorPortrait', 480, 650, true);
}

add_action('after_setup_theme', 'university_features');

//manipulowanie zapytaniami domyślnymi
function university_adjust_queries($query)
{

  //$query->set('posts_per_page', 1); //wyświetla nam tylko po jednym poście stronie itd a tego nie chcemy i jest to tylko przykład jaki to ma zasięg
  //warunek tylko wtedy gdy znajdujemy się na końcu naszej strony czyli nie jesteś w administracji naszej strony
  //oraz jest typem archiwum event
  //i jeżeli jest tylko domyślnym zapytaniem opartym url
  if (!is_admin() and is_post_type_archive('event') and is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
  //zapytanie dla wyświetlania w porządku alfabetycznym
  if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
  //zapytanie dla campus aby wyświetlał wszystkie kampusy a nie 10 defoult
  if (!is_admin() and is_post_type_archive('campus') and is_main_query()) {

    $query->set('posts_per_page', -1);
  }
}
add_action("pre_get_posts", 'university_adjust_queries');

function universityMapKey($api)
{
  $api['key'] = 'AIzaSyCCBXTbyy5VZ8aYg8moYRVWNWpGnfXf8_U';
  return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');
