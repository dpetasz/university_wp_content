import $ from "jquery";

class Search {
  // 1. describe and create our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.open = false;
    this.events();
  }

  // 2. event
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", e => {
      if (e.keyCode == 83 && !this.open) {
        this.openOverlay();
      }
      if (e.keyCode == 27 && this.open) {
        this.closeOverlay();
      }
    });
  }

  // 3. methods
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.open = true;
    console.log("włączyłem");
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.open = false;
    console.log("wyłączyłem");
  }
}

export default Search;
