// checks number of characters entered
function validateCatForm() {
  let input = document.forms["createCatForm"]["catname"].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789]*$/.test(input)
  let findSpaces = /^(\s\s)/.test(input)

  // check if right input lenght
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30 ){
      document.querySelector('#feedbackCat').innerHTML = 'Namnet måste vara kortare än 30 tecken'
    } else {
      document.querySelector('#feedbackCat').innerHTML = 'Skriv in minst två tecken'
    }
    return false
  }

  // check for latin letters
  else if(onlyLetters == false){
    document.querySelector('#feedbackCat').innerHTML = 'Namnet måste bestå av tecken från latinska alfabeten'
    return false
  }

  // check for mutliple spaces in begining of string
  else if ( findSpaces == true ){
    document.querySelector('#feedbackCat').innerHTML = 'Du skrev in för många mellanslag i rad'
    return false
  }

}