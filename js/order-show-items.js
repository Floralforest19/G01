// 1. connect to HTML-document
let dispItems = document.getElementById("dispItems")

// 2. get data from json and send it thowards getProdsToCart
function getProducts() {
  let cartFromStorage = localStorage.getItem('shoppingCart')
  let cartObj = JSON.parse(cartFromStorage)
  let products = cartObj.products
  getProdsToCart(products)
}
getProducts()

// 3. display cart with product info and delete buttons, products change for user
function getProdsToCart(products) {
  dispItems.innerHTML = `
  <thead>
    <th class='table__show-items--name'>Produkt</th>
    <th>Antal</th>
    <th>Pris</th>
    <th>Summa</th>
  </thead>`

  // 3.3 initalize totalSum
  let totalSum = 0

  // 3.4 loop over local storage to display added products
  for (let i = 0; i < products.length; i++) {
    let name = products[i].productName
    let image = products[i].productImageName
    let id = products[i].productId
    let price = products[i].productPrice
    let quantity = parseInt(products[i].quantity)
    let productSum = quantity * price
    totalSum += productSum

    // 3.4.3 display items in table
    dispItems.innerHTML += `
      <tr id='${id}' class='table-row'>
        <td class='table__show-items--name'>${name}</td>
        <td>${quantity} st</td>
        <td>${price} kr/st</td>
        <td>${productSum} kr</td>
      </tr>`
  }
  // 3.4.4 display table footer with total sum
  dispItems.innerHTML += `
  <thead>
    <th></th>
    <th></th>
    <th>Total summa: </th>
    <th>${totalSum} kr</th>
  </thead>`

}