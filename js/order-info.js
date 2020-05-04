// 1. connect to HTML-document
let dispItems = document.getElementById("dispItems")

// 2. get data from string and send it thowards getProdsToTable
function getProducts() {
  let stringJSON = document.getElementById('json').value
  let myObj = JSON.parse(stringJSON)
  let products = myObj.products
  getProdsToTable(products)
}

getProducts()

function getProdsToTable(products) {
  // loop to display added products
  for (let i = 0; i < products.length; i++) {
    let name = products[i].productName
    let id = products[i].productId
    let price = products[i].productPrice
    let newId0 = products[i].newId0;
    let newId1 = products[i].newId1;
    let newId2 = products[i].newId2;
    let quantity = parseInt(products[i].quantity)
    let productSaleQuantity = parseInt(products[i].productSaleQuantity);
    let priceText = ''

    if( productSaleQuantity < 10  && id != newId0 && id != newId1 && id != newId2){
      priceText += '<p class="sale__old">'+price+" kr</p>"
      price *= 0.9
      price = price.toFixed(2)
      priceText +=  '<p class="sale__new">'+price+' kr</p>'
    } else {
      priceText =  price
    }
    let productSum = quantity * price;

    // 3.4.3 display items in table
    let row = `
      <tr id='${id}' class='table-row'>
        <td class='table__show-items--name'>${name}</td>
        <td>${quantity} st</td>
        <td>${priceText}</td>
        <td>${productSum.toFixed(2)} kr</td>
      </tr>`
      let element = document.createElement('tr')
      element.classList.add('table-row')
      element.id = id
      element.innerHTML = row
      dispItems.prepend(element)
  }
}