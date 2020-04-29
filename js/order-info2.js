// 1. connect to HTML-document
let dispItems = document.getElementById("dispItems")

// 2. get data from json and send it thowards getProdsToCart
function getProducts() {
  let stringJSON = document.getElementById('json').value
  let myObj = JSON.parse(stringJSON)
  console.table(myObj.products)
  let products = myObj.products
  getProdsToCart(products)
}
getProducts()

// 3. display cart with product info and delete buttons, products change for user
function getProdsToCart(products) {

  // 3.4 loop over local storage to display added products
  for (let i = 0; i < products.length; i++) {
    let name = products[i].productName
    let id = products[i].productId
    let price = products[i].productPrice
    let quantity = parseInt(products[i].quantity)
    let stockQuantity = parseInt(products[i].productSaleQuantity);
    let priceText = ''

    if(stockQuantity <10){
      priceText += '<p class="sale__old" style="text-decoration: line-through">'+price+" kr</p>"
      price *= 0.9
      price = price.toFixed(2)
      priceText +=  '<p class="sale__new" style="color: #eb4b88">'+price+' kr</p>'
    } else {
      priceText =  price
    }
    let productSum = quantity * price;

    // 3.4.3 display items in table
    dispItems.innerHTML += `
      <tr id='${id}' class='table-row'>
        <td class='table__show-items--name'>${name}</td>
        <td>${quantity} st</td>
        <td>${priceText}</td>
        <td>${productSum.toFixed(2)} kr</td>
      </tr>`

    totalSum += productSum
  }
}