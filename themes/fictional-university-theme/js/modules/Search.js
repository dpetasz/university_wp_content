import $ from "jquery";

class Search {
  // 1. describe and create our object
  constructor() {
    this.addSearchHTML();
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultsDiv = $("#search-overlay__results");
    this.events();
    this.open = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  // 2. event
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  // 3. methods
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer); //przy każdym wciśnięciu wywoływana jest funkcja i aby uniknąć wykonywania poniższej instrukcji za każdym razem czyścimy timer i funkcja jest wykonywana tylko wtedy gdy upłynie określony czas
      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html(`<div class = 'spinner-loader'></div>`);
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(
      universityData.root_url + //ten opis możemy zobaczyć w unit 58 15min orez unit 60 co daje nam możliwość wyszukiwania postów i stron
      `/wp-json/wp/v2/posts?search=${this.searchField.val()}`,
      posts => {
        $.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=${this.searchField.val()}`, pages => {

          let combinedResults = posts.concat(pages);

          this.resultsDiv.html(`
        <h2 class='search-overlay__section-title'>General Information</h2>
        ${
          combinedResults.length
            ? "<ul class='link-list min-list'>"
            : "<p>Nie znalazłem żadnych informacji pasujących do tego wyszukiwania</p>"
        }
        ${combinedResults
          .map(
            item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`
          ) //join z cudzysłowem używamy aby nie pojawiały się przecinki po kolejnych iteracjach
          .join("")}
        ${combinedResults.length ? "</ul>" : ""}
        `);

          this.isSpinnerVisible = false;
        }) //ustawia nam flagę że teraz przy ponownym wpisywaniu będziemy widzieli kręciołek (bez tego czekamy na wyszukanie ale tego nie widzimy)
      }
    );
  }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.open && $("input, textarea").is(":focus")) {
      //trzecim argumentem jest zależność aby naciśnięcie s w jakimś impucie lub innym polu tekstowym nie uruchamiało przeszukiwania
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.open) {
      this.closeOverlay();
    }
  }
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301); //włącza pole do pisania z opóźnieniem aby można było pisać odrazu po włączeniu wyszukiwania a nie dopiero po najechaniu myszką

    this.open = true;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.open = false;
  }
  // tutaj jest funkcja odpowiadająca za wstawienie strony z wyszukiwaniem i będzie działała tylko gdy jest włączony js
  addSearchHTML() {
    $('body').append(`
  <div class="search-overlay">
    <div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
    </div>
    <div class="container">
        <div id="search-overlay__results"></div>
    </div>
</div>
  `);
  }

}

export default Search;