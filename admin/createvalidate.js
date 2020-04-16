function validateCatForm() {
  let input = document.forms["createCatForm"]["catname"].value;
  if (input.length < 2 ) {
    document.querySelector('#feedbackCat').innerHTML = 'Skriv in minst två tecken för att skapa en ny kategori'
    return false
  }
}