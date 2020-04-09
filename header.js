// När användaren skrollar ner 100px så göms övre delen av header och sökfältet dyker upp i menyraden
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    document.getElementById("header-top").style.maxHeight = "0px";
} else {
    document.getElementById("header-top").style.maxHeight = "1000px";
  }
} 