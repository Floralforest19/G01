let orderItems = document.getElementById("orderItems")

function getProductInfo() {
  let cartFromStorage = localStorage.getItem('shoppingCart')
  let cartObj = JSON.parse(cartFromStorage)
  let products = cartObj.products
  getProdsToForm(products)
}
getProductInfo()

function getProdsToForm(products) {
  orderItems.innerHTML = ``
  let totalSum = 0
  for (let i = 0; i < products.length; i++) {
    let product = products[i].productName
    let id = products[i].productId
    let price = products[i].productPrice
    let quantity = parseInt(products[i].quantity)
    let productSum = quantity * price
    totalSum += productSum

    orderItems.innerHTML += `
    <input type="hidden" name="product${id}_id" value="${id}"/>
    <input type="hidden" name="product${id}_product" value="${product}"/>
    <input type="hidden" name="product${id}_price" value="${price}"/>
    <input type="hidden" name="product${id}_quantity" value="${quantity}"/>
    <input type="hidden" name="product${id}_sum" value="${productSum}"/>
    `
  }
  orderItems.innerHTML += `<input type="hidden" name="order_sum" value="${totalSum}"/>`

}