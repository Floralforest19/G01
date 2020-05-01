console.log("hej");

function validateTextDescriptionInput(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789]*$/.test(
    input
  );
  let findSpaces = /^(\s\s)/.test(input);

  // check if right input lenght
  if (input.length < 2 || input.length > 300) {
    if (input.length > 300) {
      document.getElementById(feedbackId).innerHTML =
        "Måste vara kortare än 300 tecken";
    } else {
      document.getElementById(feedbackId).innerHTML =
        "Skriv in minst två tecken";
    }
    return false;
  }

  // check for latin letters
  else if (onlyLetters == false) {
    document.getElementById(feedbackId).innerHTML =
      "Endast tecken från latinska alfabeten tillåtet";
    return false;
  }

  // check for mutliple spaces in begining of string
  else if (findSpaces == true) {
    document.getElementById(feedbackId).innerHTML =
      "För många mellanslag i rad";
    return false;
  }
  return true;
}

function validateQuantityInput(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyNumbers = /^[0123456789]*$/.test(input);

  console.log(onlyNumbers);
  if (input < 0 || onlyNumbers == false) {
    document.getElementById(feedbackId).innerHTML =
      "Bara positiva heltal, tack";
    return false;
  }
  return true;


}

