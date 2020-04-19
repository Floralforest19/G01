// checks number of characters entered
function validateCatForm() {
  let input = document.forms["createCatForm"]["catname"].value;
  // check if right input lenght
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30 ){
      document.querySelector('#feedbackCat').innerHTML = 'Namnet måste vara kortare än 30 tecken'
    } else {
      document.querySelector('#feedbackCat').innerHTML = 'Skriv in minst två tecken'
    }
    return false
  } 
  // regular expression to check for latin letters
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789]*$/.test(input)
  if(onlyLetters == false){
    document.querySelector('#feedbackCat').innerHTML = 'Namnet måste bestå av tecken från latinska alfabeten'
    return false
  }
}