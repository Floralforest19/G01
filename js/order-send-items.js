let orderItems = document.getElementById("orderItems");

function getProductInfo() {
  let cartFromStorage = localStorage.getItem('shoppingCart')
  let cartObj = JSON.parse(cartFromStorage)
  let products = cartObj.products
  getProdsToForm(products)
}
getProductInfo();

function getProdsToForm(products) {
  orderItems.innerHTML = ``
  let totalSum = 0
  let numbOfDiffProds = 0;
  for (let i = 0; i < products.length; i++) {
    numbOfDiffProds++
    let id = products[i].productId
    let price = products[i].productPrice
    let quantity = parseInt(products[i].quantity)
    //
    let productSaleQuantity = parseInt(products[i].productSaleQuantity);
    let priceText = ''

    if (productSaleQuantity < 10) {
      price *= 0.9
      price = price.toFixed(2)
    } else {
      priceText = price
    }

    let productSum = quantity * price
    totalSum += productSum

    let value = `${id},${price},${quantity}`
    orderItems.innerHTML += `<input type="hidden" name="${i}" value="${value}"/>`
  }
  orderItems.innerHTML += `<input type="hidden" name="numbOfDiffProds" value="${numbOfDiffProds}"/>`
  orderItems.innerHTML += `<input type="hidden" name="order_sum" value="${totalSum}"/>`
}
