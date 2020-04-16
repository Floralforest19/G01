/* 
* Validates search bar input, executes form action if 2+ characters
*/

function validateBarForm() {
  let input = document.forms["searchBarForm"]["input"].value;
  if (input.length < 2 ) {
    console.log(input)
    document.querySelector('#feedbackBar').innerHTML = 'Skriv in minst två tecken för att söka'
    return false
  }
}