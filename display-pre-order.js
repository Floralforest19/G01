// let shoppingCart = localStorage.getItem("shoppingCart");

// console.log(shoppingCart);

function getProducts() {
  let cartFromStorage = localStorage.getItem("shoppingCart");
  let cartObj = JSON.parse(cartFromStorage);
  let products = cartObj.products;
  getProdsToCart(products);
  console.log(products);
}
getProducts();



// order-process(shoppinggcart)
