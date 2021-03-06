<?php
get_header();
while (have_posts()) {
  the_post();
  pageBanner();
  ?>


  <div class="container container--narrow page-section">

    <?php
    $theParent = wp_get_post_parent_id(get_the_ID()); //pobiera wartość jeżeli nie ma rodzica to 0 jeżeli ma to id rodzica
    if ($theParent) { ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
      </div>
    <?php }
  ?>
    <!-- funkcja sprawdzająca czy strona posiada dzieci, 
                                                jeżeli nie to nie będzie wyświetlane menu z podstronami -->

    <?php
    // zwraca listę stron z pamięci;
    $testArray = get_pages(array(
      'child_of' => get_the_ID(),
    ));


    // sprawdzamy czy bieżąca strona ma rodzica lub jeśli jest rodzicem
    if ($theParent or  $testArray) { ?>
      <!-- menu z linkami do strony podrzędnej unit17 -->
      <div class="page-links">
        <!--link do strony, która zawiera dzieci dynamicznie przypisanie tytułu strony-->
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent) ?>
          </a></h2>
        <ul class="min-list">
          <?php
          // funkcja bez argumentów wyświetla nam wszystkie strony, a chodzi byśmy widzieli 
          // strony podrzędne tylko danej strony i jeżeli strona nie ma dzieci to nic nie 
          // wyswietla, a chodzi żeby były widoczne linki stron podrzędnych

          // wp_list_pages();
          if ($theParent) {
            $findChildrenOf = $theParent;
            //jeżeli strona ma dzieci to przypisujemy do zmiennej nr strony rodzica
          } else $findChildrenOf = get_the_ID();
          //jeżeli strona nie ma rodzica to przypisujeny do zminnej nr id bierzącej strony 
          // i wtym przypadku widzimy zawsze linki do podstron
          wp_list_pages(array(
            'title_li' => null, //tytuł który się pojawił 'strony' nie będzie widoczny
            'child_of' =>  $findChildrenOf,
            // przypisanie do tablicy zmiennnej stron
          ));

          ?>
          <!-- <li class="current_page_item"><a href="#">Our History</a></li>
                                                                                            <li><a href="#">Our Goals</a></li> -->
        </ul>
      </div>
    <?php  } ?>
    <div class="generic-content">

      <?php the_content(); ?>
      <!-- treść posta pobierana z wordpress -->
    </div>

  </div>


<?php
}

get_footer();
?>