function validateCatForm() {
  let input = document.forms["createCatForm"]["catname"].value;
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30 ){
      document.querySelector('#feedbackCat').innerHTML = 'Kategorin måste vara kortare än 30 tecken'
    } else {
      document.querySelector('#feedbackCat').innerHTML = 'Skriv in minst två tecken'
    }
    return false
  } 
}