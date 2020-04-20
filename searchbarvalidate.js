/* 
* Validates search bar input, executes form action if 2+ characters
*/

function validateBarForm() {
  let input = document.forms["searchBarForm"]["input"].value;
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30 ){
      document.querySelector('#feedbackBar').innerHTML = 'Sökningen måste vara kortare än 30 tecken'
    } else {
      document.querySelector('#feedbackBar').innerHTML = 'Skriv in minst två tecken för att söka'
    }
    return false
  }
}