function setAddProductToCartClickEvent() {
  let addToCartButtons = document.querySelectorAll(".add-to-cart");
  updateCart2();
  //loopa över alla knappar
  for (let i = 0; i < addToCartButtons.length; i++) {
    let addToCartButton = addToCartButtons[i];

    //hämta ut parent till knappen
    let addToCartButtonParent = addToCartButton.parentElement;

    //hämta ut parents children som är input element som innehåller
    let hiddenProductIdInput = addToCartButtonParent.querySelector(
      ".product-id"
    );
    let hiddenProductPrice = addToCartButtonParent.querySelector(
      ".product-price"
    );
    let hiddenProductImage = addToCartButtonParent.querySelector(
      ".product-image"
    );
    let hiddenProductName = addToCartButtonParent.querySelector(
      ".product-name"
    );
    let hiddenProductSale = addToCartButtonParent.querySelector(
      ".product-sale"
    );
    let hiddenProductNew0 = addToCartButtonParent.querySelector(
      ".product-new0"
    );
    let hiddenProductNew1 = addToCartButtonParent.querySelector(
      ".product-new1"
    );
    let hiddenProductNew2 = addToCartButtonParent.querySelector(
      ".product-new2"
    );

    let productId = hiddenProductIdInput.value;
    let productPrice = hiddenProductPrice.value;
    let productName = hiddenProductName.value;
    let productImageName = hiddenProductImage.value;
    let productSaleQuantity = hiddenProductSale.value;
    let newId0 = hiddenProductNew0.value;
    let newId1 = hiddenProductNew1.value;
    let newId2 = hiddenProductNew2.value;

    // console.log(productNew0)
    //binda ett click event på alla lägg till knappar och skicka med produkt-id, namn, pris, antal och bild.
    addToCartButton.addEventListener("click", function () {
      //hämta ut current value från antalfältet vid klick
      let chosenQuantityElement = addToCartButtonParent.querySelector(
        ".product-quantity"
      );
      let quantity = parseFloat(chosenQuantityElement.value);
      let maxAllowedQuantity = parseInt(
        chosenQuantityElement.getAttribute("max")
      );

      let quantityValidated = validateShoppingCartQuantity(
        quantity,
        maxAllowedQuantity
      );

      if (quantityValidated === false) {
        alert(
          `Valt antal måste vara ett helnummmer mellan 1 och ${maxAllowedQuantity}`
        );
        return;
      }

      //hämta cart från localstorage
      let shoppingCart = getShoppingCartFromLocalStorage();
      //console.log("Hämtat shopping cart: " + JSON.stringify(shoppingCart));

      //kolla om produkten finns i varukorgen
      let indexOfExisting = shoppingCart.products.findIndex(
        (product) => product.productId === productId
      );
      //om den finns, då skall vi updatera denna med quantity
      if (indexOfExisting !== -1) {
        let existingProduct = shoppingCart.products[indexOfExisting];

        let newQuantity = existingProduct.quantity + quantity;
        if (newQuantity > maxAllowedQuantity) {
          alert("Det finns inte tillräckligt många varor i lager");
          return;
        }

        existingProduct.quantity = existingProduct.quantity + quantity;

        //spara med nya antalet
        shoppingCart.products[indexOfExisting] = existingProduct;
      } else {
        // lägg till rea status
        if (maxAllowedQuantity < 10) {
          productSaleQuantity = maxAllowedQuantity;
        } else {
          productSaleQuantity = maxAllowedQuantity;
        }
        //skapa ett javascript objekt för EN produkt och sätt dess properties
        let product = {
          productName: productName,
          productImageName: productImageName,
          productId: productId,
          productPrice: productPrice,
          quantity: quantity,
          productSaleQuantity: productSaleQuantity,
          newId0: newId0,
          newId1: newId1,
          newId2: newId2,
        };

        //lägg till produkten i shoppingcarten
        shoppingCart.products.push(product);
        console.log(
          "Sparat ny product i shopping cart: " + JSON.stringify(shoppingCart)
        );
      }

      saveShoppingCartInLocalStorage(shoppingCart);

      console.log(JSON.stringify(shoppingCart));

      updateCart2();
    });
  }
}

function updateCart2() {
  let sum = 0;
  if(localStorage.getItem("shoppingCart") == null) {
    let emptyShoppingCart = {
      products: [],
    };

  let shoppingCartString = JSON.stringify(emptyShoppingCart);
  window.localStorage.setItem("shoppingCart", shoppingCartString);
  }
  if (localStorage.getItem("shoppingCart").length > 0) {
    let products = JSON.parse(localStorage.getItem("shoppingCart")).products;
    for (let i = 0; i < products.length; i++) {
      sum += products[i].quantity;
    }
  }
  document.getElementById("updateCart").innerHTML = " (" + sum + ")";
}