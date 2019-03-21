<?php
get_header();
while(have_posts()){
    the_post();?>
     <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>NIE ZAPOMNIJ ZASTĄPIĆ MNIE PÓŹNIEJ</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
  <?php 
  $theParent = wp_get_post_parent_id(get_the_ID());
if ($theParent){
?>
<p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title();?></span></p>
    
<?php
} else{
   ?> 
   <!-- zwracamy tytuł posta -->
<p> <span class="metabox__main"><?php the_title();?></span></p>
    
<?php
}

  ?>
</div>

      <!-- funkcja sprawdzająca czy strona posiada dzieci, 
      jeżeli nie to nie będzie wyświetlane menu z podstronami -->

      <?php
      // zwraca listę stron z pamięci;
      $testArray = get_pages(array(
        'child_of'=> get_the_ID(),
      ));
      echo $testArray;
      
      if ($theParent or  $testArray){ ?>
    <!-- menu z linkami do strony podrzędnej unit17 -->
    <div class="page-links">
       <!--link do strony, która zawiera dzieci dynamicznie przypisanie tytułu strony-->
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent)
      
       ?></a></h2>
      <ul class="min-list">
        <?php 
        // funkcja bez argumentów wyświetla nam wszystkie strony, a chodzi byśmy widzieli 
        // strony podrzędne tylko danej strony i jeżeli strona nie ma dzieci to nic nie 
        // wyswietla, a chodzi żeby były widoczne linki stron podrzędnych

        // wp_list_pages();
        if($theParent){
          $findChildrenOf = $theParent; 
          //jeżeli strona ma dzieci to przypisujemy do zmiennej nr strony rodzica
        } else $findChildrenOf = get_the_ID(); 
        //jeżeli strona nie ma rodzica to przypisujeny do zminnej nr id bierzącej strony 
        // i wtym przypadku widzimy zawsze linki do podstron
        wp_list_pages(array(
          'title_li'=> null,//tytuł który się pojawił 'strony' nie będzie widoczny
          'child_of'=>  $findChildrenOf,
          // przypisanie do tablicy zmiennnej stron
        ));
        
        ?>
        <!-- <li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li> -->
      </ul>
    </div>
<?php  } ?>
    <div class="generic-content">
    
        <?php the_content();?><!-- treść posta pobierana z wordpress -->
     </div>

  </div>

    
    <?php
}

get_footer();
?>