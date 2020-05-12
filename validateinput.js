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
      document.getElementById(feedbackId).innerHTML = "Max 30 tecken";
    } else {
      document.getElementById(feedbackId).innerHTML = "Minst två tecken";
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

function validateNameInput(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎîíÍ]*$/.test(input);
  let findSpaces = /^(\s\s)/.test(input);

  // check if right input lenght
  if (input.length < 2 || input.length > 30) {
    if (input.length > 30) {
      document.getElementById(feedbackId).innerHTML =
        "Max 30 tecken";
    } else {
      document.getElementById(feedbackId).innerHTML =
        "Minst två tecken";
    }
    return false;
  }

  // check for latin letters
  else if (onlyLetters == false) {
    document.getElementById(feedbackId).innerHTML = "Endast bokstäver";
    return false;
  }

  // check for mutliple spaces in begining of string
  else if (findSpaces == true) {
    document.getElementById(feedbackId).innerHTML =
      "För många mellanslag";
    return false;
  }
  return true;
}

function validateEmail(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let email = document.forms[formName][inputName].value;
  if (email) {
    //alert(email.length);
    if (email.length > 64) {
      document.getElementById(feedbackId).innerHTML = "Ogiltig emailadress";
      return false;
    }
  }
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
    return true;
  }

  document.getElementById(feedbackId).innerHTML = "Ogiltig emailadress";
  return false;
}

function validatePhonenumber(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let phone = document.forms[formName][inputName].value;
  //svenska mobilnummer: ^([+]46)\s*(7[0236])\s*(\d{4})\s*(\d{3})$
  var phoneno = /* /([-\s]?\d){6,10}/;*/ /^([0-9-+]){6,15}$/;
  if (phone.match(phoneno)) {
    return true;
  }
  document.getElementById(feedbackId).innerHTML = "Ogiltigt telefonnummer";
  return false;
}

function validateTextarea(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  if (input.length == 0) {
    document.getElementById(feedbackId).innerHTML = "Fyll i ditt meddelende";
  }
  return true;
}

// checks number of characters entered
function validateAddress(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyLetters = /^[a-zA-Z\- ÅåÄäÖöØøÆæÉéÈèÜüÊêÛûÎî0123456789,/]*$/.test(
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

//[0-9 ]+
function validateNumberOrSpaces(formName, inputName, feedbackId) {
  document.getElementById(feedbackId).innerHTML = "";
  let input = document.forms[formName][inputName].value;
  let onlyNumbers = /^[0-9 ]*$/.test(input);
  let findSpaces = /(\s\s)/.test(input);

  // check if right input lenght
  if (input.length < 5) {
    document.getElementById(feedbackId).innerHTML =
      "Skriv in minst fem siffror";
    return false;
  } else if (input.length > 6) {
    document.getElementById(feedbackId).innerHTML =
      "Måste vara kortare än 6 siffror";

    return false;
  }
  // check for latin letters
  else if (onlyNumbers == false) {
    document.getElementById(feedbackId).innerHTML =
      "Endast siffror och mellanslag tillåtet";
    return false;
  }

  // check for mutliple spaces in begining of string
  else if (findSpaces == true) {
    document.getElementById(feedbackId).innerHTML =
      "För många mellanslag i rad";
    return false;
  }
}
