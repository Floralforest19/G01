// När användaren skrollar ner 100px så göms övre delen av header och sökfältet dyker upp i menyraden
window.onscroll = function() {scrollFunction()};
// window.onscroll = function() {setTimeout(() => { scrollFunction(); },300)};

const headerTop = document.getElementById("header-top");
const headLogo = document.getElementById("header-logo-main");
const headSearch = document.getElementById("header-search");
const headNav = document.getElementById("header-nav");

function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        document.getElementById("header-top").style.maxHeight = "0px";
        setTimeout(() => { headNav.appendChild(headSearch); }, 300);
        setTimeout(() => { headNav.prepend(headLogo); }, 300);
    } else {
        document.getElementById("header-top").style.maxHeight = "1000px";
        headerTop.prepend(headSearch);
        headerTop.prepend(headLogo);
    }
}