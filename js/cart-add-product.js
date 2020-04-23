function setAddProductToCartClickEvent() {
  let addToCartButtons = document.querySelectorAll(".add-to-cart");

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

    let productId = hiddenProductIdInput.value;
    let productPrice = hiddenProductPrice.value;
    let productName = hiddenProductName.value;
    let productImageName = hiddenProductImage.value;

    //binda ett click event på alla lägg till knappar och skicka med produkt-id, namn, pris, antal och bild.
    addToCartButton.addEventListener("click", function () {
      //hämta ut current value från antalfältet vid klick
      let chosenQuantity = addToCartButtonParent.querySelector(
        ".product-quantity"
      );
      let quantity = parseInt(chosenQuantity.value);

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
        existingProduct.quantity = existingProduct.quantity + quantity;

        //spara med nya antalet
        shoppingCart.products[indexOfExisting] = existingProduct;
      } else {
        //skapa ett javascript objekt för EN produkt och sätt dess properties
        let product = {
          productName: productName,
          productImageName: productImageName,
          productId: productId,
          productPrice: productPrice,
          quantity: quantity,
        };

        //lägg till produkten i shoppingcarten
        shoppingCart.products.push(product);
        console.log(
          "Sparat ny product i shopping cart: " + JSON.stringify(shoppingCart)
        );
      }

      saveShoppingCartInLocalStorage(shoppingCart);

      console.log(JSON.stringify(shoppingCart));

      //Att tänka på:
      //här kannske vi vill updatera en shopping cart icon
      //här kannske vi vill rendera någonting på sidan
    });
  }
}
