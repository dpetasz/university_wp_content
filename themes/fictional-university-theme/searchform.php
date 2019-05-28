<!-- esc_url służy do bezpieczeństwa (polityka bezpieczeństwa) a site_url służy do wygenerowania strony głównej -->
<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
    <label class="headline headline--medium" for="s">Perform a New Search:</label>
    <div class="search-form-row">

        <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s"><!-- s daje nam możliwość wyświetlania w przeglądarce s co będzie służlyło do przeglądania to jest w unit 72  -->
        <input class="search-submit" type="submit" value="Search">
    </div>
</form>
<!-- unit 73 18 min -->