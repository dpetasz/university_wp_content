import $ from "jquery";

class Search {
  // 1. describe and create our object
  constructor() {
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
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(
      universityData.root_url +
        `/wp-json/wp/v2/posts?search=${this.searchField.val()}`,
      posts => {
        this.resultsDiv.html(`
        <h2 class='search-overlay__section-title'>General Information</h2>
        ${
          posts.length
            ? "<ul class='link-list min-list'>"
            : "<p>Nie znalazłem żadnych informacji pasujących do tego wyszukiwania</p>"
        }
        ${posts
          .map(
            post => `<li><a href="${post.link}">${post.title.rendered}</a></li>`
          ) //join z cudzysłowem używamy aby nie pojawiały się przecinki po kolejnych iteracjach
          .join("")}
        ${posts.length ? "</ul>" : ""}
        `);
        this.isSpinnerVisible = false; //ustawia nam flagę że teraz przy ponownym wpisywaniu będziemy widzieli kręciołek (bez tego czekamy na wyszukanie ale tego nie widzimy)
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
    this.open = true;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.open = false;
  }
}

export default Search;
