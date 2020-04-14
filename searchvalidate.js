/* 
* Validates search input, executes form action if over 
*/
const filterfield = document.querySelector('#filter')
const table = document.querySelector('#products')

function validateForm() {
  let input = document.forms["searchForm"]["input"].value;
  if (input.length < 2 ) {
    document.querySelector('#feedback').innerHTML = 'Skriv in minst två tecken för att söka'
    return false
  }
}