function setAddProductToCartClickEvent() {
  let addToCartButtons = document.querySelectorAll(".add-to-cart");
  console.log("test");
  //loopa över alla knappar
  for (let i = 0; i < addToCartButtons.length; i++) {
    let addToCartButton = addToCartButtons[i];

    //hämta ut parent till knappen
    let addToCartButtonParent = addToCartButton.parentElement;

    //hämta ut parents children som är input element som innehåller
    //produkt-id, pris och antal.
    let hiddenProductIdInput = addToCartButtonParent.querySelector(
      ".product-id"
    );
    let hiddenProductPrice = addToCartButtonParent.querySelector(
      ".product-price"
    );

    let chosenQuantity = addToCartButtonParent.querySelector(
      ".product-quantity"
    );

    //binda ett click event på alla lägg till knappar och skicka med produkt-id, pris och antal.
    addToCartButton.addEventListener("click", function () {
      alert(
        `produkt id: ${hiddenProductIdInput.value} pris: ${hiddenProductPrice.value} antal: ${chosenQuantity.value}`
      );
    });
  }
}
