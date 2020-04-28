function getProducts() {
let cartFromStorage = localStorage.getItem('shoppingCart')
let cartObj = JSON.parse(cartFromStorage)
let products = cartObj.products
getProdsToCart(products)
}
