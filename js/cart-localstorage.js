//Skapa en ny shopping cart och spara den i local storage
function createNewShoppingCartInLocalStorage() {
  let emptyShoppingCart = {
    products: [],
  };
  saveShoppingCartInLocalStorage(emptyShoppingCart);
  return emptyShoppingCart;
}

//https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage
function getShoppingCartFromLocalStorage() {
  let shoppingCartString = window.localStorage.getItem("shoppingCart");

  //om det inte finns någon cart ännu i local storage - skapa en ny och returnera denna.
  if (shoppingCartString == null) {
    let newShoppingCart = createNewShoppingCartInLocalStorage();
    return newShoppingCart;
  }

  let shoppingCart = JSON.parse(shoppingCartString);
  return shoppingCart;
}

//Spara shoppingCart i local storage
function saveShoppingCartInLocalStorage(shoppingCart) {
  let shoppingCartString = JSON.stringify(shoppingCart);
  window.localStorage.setItem("shoppingCart", shoppingCartString);
}

//Töm allt i local storage
function clearShoppingCartLocalStorage() {
  window.localStorage.removeItem("shoppingCart");
}
