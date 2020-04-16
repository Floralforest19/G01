function validateForm() {
  let input = document.forms["createCatForm"]["catname"].value;
  if (input.length < 2 ) {
    document.querySelector('#feedbackCat').innerHTML = 'Skriv in minst två tecken för att söka'
    return false
  }
}