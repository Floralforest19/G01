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
  dispItems.innerHTML = `
  <thead>
    <th class='table__show-items--name'>Produkt</th>
    <th>Antal</th>
    <th>Pris</th>
    <th>Summa</th>
  </thead>`

  // 3.3 initalize totalSum
  let totalSum = 0
  let shippingFee = 50;

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

    if(totalSum >= 500){
      shippingFee = 0
    } else {
      shippingFee = 50
    }
  }
  // 3.4.4 display table footer with total sum
  dispItems.innerHTML += `
  <tr>
    <td></td>
    <td></td>
    <td>Produktsumma: </td>
    <td>${totalSum.toFixed(2)} kr</td>
  </tr>`
  if(shippingFee == 50 ){
    let shippingCity = checkCity().toLowerCase()
    if(shippingCity == 'stockholm'){
      shippingFee = 0
    }
  }
  dispItems.innerHTML += `
  <tr>
    <td></td>
    <td></td>
    <td>Fraktavgift: </td>
    <td id="shippingFee">${shippingFee} kr</td>
  </tr>`
  dispItems.innerHTML += `
  <thead>
    <th></th>
    <th></th>
    <th>Total summa: </th>
    <th>${(totalSum+shippingFee).toFixed(2)} kr</th>
  </thead>`
  // document.getElementById('amountWithSale').innerHTML = (totalSum+shippingFee).toFixed(2)+" kr";

}

function checkCity(){
  let otherCity = document.getElementById('otherCity')
  let customerCity = document.getElementById('customerCity')
  // Kolla om det är i sthlm 
  if( otherCity.innerHTML == null ){
    let shippingCity = customerCity.innerHTML
    if(shippingCitytoLowerCase() == 'stockholm'){
      
    }
    return shippingCity
  } else {
    let shippingCity = otherCity.innerHTML
    return shippingCity
  }
}