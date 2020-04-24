// 1. connect to HTML-document
let dispCart = document.getElementById("dispCart");

// 2. get data from json and send it thowards getProdsToCart
function getProducts() {
  let cartFromStorage = localStorage.getItem("shoppingCart");
  let cartObj = JSON.parse(cartFromStorage);
  let products = cartObj.products;
  getProdsToCart(products);
  setUpPlusQuantityClickEvent();
}
getProducts();

// 3. update cart in header with current product sum
updateCart();

// 3. display cart with product info and delete buttons, products change for user
function getProdsToCart(products) {
  // 3.1 clears dispCart innerHTML to enable putting in new info
  dispCart.innerHTML = "";

  // 3.2 either writes empty cart to user or  creates a table heading
  ifEmptyCart();

  // 3.update cart in header with current cart product-item sum
  updateCart();

  // 3.3 initalize totalSum
  let totalSum = 0;

  // 3.4 loop over local storage to display added products
  for (let i = 0; i < products.length; i++) {
    let name = products[i].productName;
    let image = products[i].productImageName;
    let id = products[i].productId;
    let price = products[i].productPrice;
    let quantity = parseInt(products[i].quantity);
    let productSum = quantity * price;
    totalSum += productSum;

    // 3.4.3 display items in table
    dispCart.innerHTML += `
      <tr id='${id}' class='table-row'>
        <td>${name}</td>
        <td><button id='${id}MinusBtn' class='minus'><i class='fa fa-minus'></i></button>
        <input type='text' id='${id}Input' class='inputAmount' value='${quantity}'></input>
        <button id='${id}PlusBtn' class='plus'><i class='fa fa-plus'></i></button></td>
        <td>${price} kr</td>
        <td>${productSum} kr</td>
        <td><button id ='${id}deleteBtn' class='btn__delete'><i class='fa fa-trash'></i></button></td>
      </tr>`;
  }
  // 3.4.4 display table footer with total sum
  dispCart.innerHTML += `
  <thead><tr class='table-row thead'>
    <th></th><th></th><th></th><th>Total summa: </th><th>${totalSum} kr</th></tr>
  </thead>`;
  // 3.4.5 display order button
  if (localStorage.getItem("shoppingCart").length > 0) {
    dispCart.innerHTML += `<thead class='thead thead-dark'><tr>
      <th></th><th></th><th></th><th></th><th><a href='order-form.php'><button id='orderBtn' class='btn__edit'>Beställ</button></a></th>
    </tr></thead>`;
  }
  // 3.5 add lister to clear cart button
  clearCartBtn();
}

// 3.2 either writes empty cart or table heading
function ifEmptyCart() {
  if (localStorage.getItem("shoppingCart").length > 0) {
    document.getElementById("emptyCart").innerHTML = "";
    dispCart.innerHTML += `
    <thead class='thead thead-dark'><tr>
      <th>Produkt</th><th>Antal</th><th>Pris/st</th><th>Summa</th>
      <th><button id='clearCartBtn' class='btn__delete'>Töm varukorg</button></th>
    </tr></thead>`;
  } else {
    document.getElementById("emptyCart").innerHTML = "Varukorgen är tom!";
  }
}

// 3. update cart in header with current cart ticket-sum
function updateCart() {
  let sum = 0;
  if (localStorage.getItem("shoppingCart").length > 0) {
    let products = JSON.parse(localStorage.getItem("shoppingCart")).products;
    for (let i = 0; i < products.length; i++) {
      sum += products[i].quantity;
    }
  }
  document.getElementById("updateCart").innerHTML = " (" + sum + ")";
}

// 3.5 put listers on clear cart Btn
function clearCartBtn() {
  document
    .getElementById("clearCartBtn")
    .addEventListener("click", function () {
      // if current btn is "clear cart" clear local storage
      if (confirm("Vill du tömma varukorgen?") == true) {
        localStorage.clear();
        // getProducts() borde köras egentligen istället för reload
        location.reload();
      }
      // rewrite cart
      getProducts();
    });
}

//-----plus minus quantity buttons-----//

function setUpPlusQuantityClickEvent() {
  //Hämta ut alla plus antal knappar
  let plusQuantityButtons = document.querySelectorAll(".plus");

  for (let i = 0; i < plusQuantityButtons.length; i++) {
    let plusQuantityButton = plusQuantityButtons[i];

    plusQuantityButton.addEventListener("click", function () {
      let plusQuantityButtonParent =
        plusQuantityButton.parentElement.parentElement;
      let productId = plusQuantityButtonParent.getAttribute("id");

      let shoppingCart = getShoppingCartFromLocalStorage();

      //sök fram vart produkten ligger i carten
      let productIndex = shoppingCart.products.findIndex(
        (product) => product.productId === productId
      );

      //hämta ut produkten
      //console.log("productIndex: " + productIndex);
      //console.log("cart: " + JSON.stringify(shoppingCart));
      //console.log("productid: " + productId);
      let foundProduct = shoppingCart.products[productIndex];
      console.log(JSON.stringify(foundProduct));
      let currentQuantity = foundProduct.quantity;

      //öka med 1
      currentQuantity = currentQuantity + 1;

      //uppdatera objektet
      foundProduct.quantity = currentQuantity;

      //spara produkten i varukorgen på rätt index
      shoppingCart.products[productIndex] = foundProduct;

      //spara varukorgen i local storage
      saveShoppingCartInLocalStorage(shoppingCart);

      //rendera ut allt igen
      getProducts();
    });
  }
}
