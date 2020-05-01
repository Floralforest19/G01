// checks number of characters entered
function validateForm(formName, inputName, feedbackId) {
  let input = document.forms[formName][inputName].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789]*$/.test(
    input
  );
  let findSpaces = /^(\s\s)/.test(input);

  // check if right input lenght
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30) {
      document.getElementById(feedbackId).innerHTML =
        "Måste vara kortare än 30 tecken";
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
}

function validateTextInput(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789]*$/.test(
    input
  );
  let findSpaces = /^(\s\s)/.test(input);

  // check if right input lenght
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30) {
      document.getElementById(feedbackId).innerHTML =
        "Måste vara kortare än 30 tecken";
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

function validateEmail(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let email = document.forms[formName][inputName].value;
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
    return true;
  }

  document.getElementById(feedbackId).innerHTML = "Ogiltig emailadress";
  return false;
}

function validatePhonenumber(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let phone = document.forms[formName][inputName].value;
  var phoneno = /* /([-\s]?\d){6,10}/;*/ /^([0-9-+]){6,30}$/;
  if (phone.match(phoneno)) {
    return true;
  }
  document.getElementById(feedbackId).innerHTML = "Ogiltigt telefonnummer";
  return false;
}
