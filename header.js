// När användaren skrollar ner 100px så göms övre delen av header och sökfältet dyker upp i menyraden
window.onscroll = function() {scrollFunction()};
// window.onscroll = function() {setTimeout(() => { scrollFunction(); },300)};

const body = document.querySelectorAll(".header-top, .header-search, .header-button-a");
const header = document.getElementById("header");
const headerTop = document.getElementById("header-top");
const headLogo = document.getElementById("header-logo-main");
const headSearch = document.getElementById("header-search");
const headNav = document.getElementById("header-nav");
const dropdownMenu = document.getElementById("dropdownMenu");

function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        headerTop.style.maxHeight = "0px";

        // setTimeout(() => { headNav.appendChild(headSearch); }, 300);
        headLogo.style.maxHeight = headerTop.style.maxHeight;
    } else {
        headerTop.style.maxHeight = "12.5vh";

        // headerTop.prepend(headSearch);
        // headerTop.prepend(headLogo);
        headLogo.style.maxHeight = "11vh";
    }
}

headNav.addEventListener("click", function () {
    headNav.classList.toggle("change");

    dropdownMenu.classList.toggle("show");

    for(let i = 0, all = body.length; i < all; i++){   
        body[i].classList.toggle('menu-fader');
    }
});