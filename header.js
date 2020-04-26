const header = document.getElementById("header");
const headerTop = document.getElementById("header-top");
const headLogo = document.getElementById("header-logo-main");
const headSearch = document.getElementById("header-search");
const headNav = document.getElementById("header-nav");
const dropdownMenu = document.getElementById("dropdownMenu");

const goTop = document.getElementById("goTop");

const exitDropdownMenu = document.querySelectorAll("*:not(dropdownMenu)");
const fadeHeader = document.querySelectorAll(
  ".header-top, .header-search, .header-button-a, .goTop"
);
const main = document.getElementById("main");

// Endast mobil och mindre än 800px
if (
  /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  )
) {
  window.onscroll = function () {
    scrollFunctionHeader();
  };
}
function scrollFunctionHeader() {
  // När användaren skrollar ner 100px så göms Loggan i headern.
  if (
    document.body.scrollTop > 100 ||
    document.documentElement.scrollTop > 100
  ) {
    headerTop.style.maxHeight = "0px";

    headLogo.style.maxHeight = headerTop.style.maxHeight;
  } else {
    headerTop.style.maxHeight = "12.5vh";

    headLogo.style.maxHeight = "11vh";
  }
  // När användaren skrollar ner 200px så syns knappen som tar en till toppen av sidan.
  if (
    document.body.scrollTop > 200 ||
    document.documentElement.scrollTop > 200
  ) {
    goTop.style.display = "unset";
  } else {
    goTop.style.display = "none";
  }
}

if (
  /Android|webOS|firefox|chrome|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  )
) {
  headNav.addEventListener("click", function () {
    headNav.classList.toggle("change");
    dropdownMenu.classList.toggle("show");

    main.classList.toggle("menu-fader");

    for (let i = 0, all = fadeHeader.length; i < all; i++) {
      fadeHeader[i].classList.toggle("menu-fader");
    }
  });
}

if (
  /Android|webOS|firefox|chrome|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  )
) {
  window.addEventListener("click", function (e) {
    if (
      !document.getElementById("header-nav").contains(e.target) &&
      dropdownMenu.classList.contains("show")
    ) {
      dropdownMenu.classList.toggle("show");
      headNav.classList.toggle("change");

      main.classList.toggle("menu-fader");

      for (let i = 0, all = fadeHeader.length; i < all; i++) {
        fadeHeader[i].classList.toggle("menu-fader");
      }
    }
  });
}
