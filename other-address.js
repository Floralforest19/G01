function otherAddress() {
  // Get the checkbox
  let checkBox = document.getElementById("leverans");
  // Get the output text
  let checked = document.getElementById("checked");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true) {
    checked.style.display = "block";
  } else {
    checked.style.display = "none";
  }
}
