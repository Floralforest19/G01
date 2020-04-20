/* 
* Validates search input, executes form action if over 
*/

function validateForm() {
  let input = document.forms["searchForm"]["input"].value;
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30 ){
      document.querySelector('#feedback').innerHTML = 'Sökningen måste vara kortare än 30 tecken'
    } else {
      document.querySelector('#feedback').innerHTML = 'Skriv in minst två tecken för att söka'
    }
    return false
  }
}