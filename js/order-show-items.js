// 1. connect to HTML-document
let dispItems = document.getElementById("dispItems");

// 2. get data from json and send it thowards getProdsToCart
function getProducts() {
  let cartFromStorage = localStorage.getItem("shoppingCart");
  let cartObj = JSON.parse(cartFromStorage);
  let products = cartObj.products;
  getProdsToCart(products);
}

// Read query string from url
const urlParams = new URLSearchParams(window.location.search);


getProducts();


// 3. display cart with product info and delete buttons, products change for user
function getProdsToCart(products) {
  dispItems.innerHTML = `
  <thead class='t-top-order'>
    <th class='table__show-items--name'>Produkt</th>
    <th>Antal</th>
    <th>Pris</th>
    <th>Summa</th>
  </thead>`;

  // 3.3 initalize totalSum
  let shippingFee = 50;
  var totalSum = 0;

  // 3.4 loop over local storage to display added products
  for (let i = 0; i < products.length; i++) {
    let name = products[i].productName;
    let id = products[i].productId;
    let price = products[i].productPrice;
    let quantity = parseInt(products[i].quantity);
    let productSaleQuantity = parseInt(products[i].productSaleQuantity);
    let priceText = "";

    if (productSaleQuantity < 10) {
      priceText += '<p class="sale__old">' + price + " kr</p>";
      price *= 0.9;
      price = price.toFixed(2);
      priceText += '<p class="sale__new">' + price + " kr</p>";
    } else {
      priceText = price;
    }
    let productSum = quantity * price;

    // 3.4.3 display items in table
    dispItems.innerHTML += `
      <tr id='${id}' class='table-row'>
        <td class='table__show-items--name name-td'>${name}</td>
        <td>${quantity} st</td>
        <td>${priceText}</td>
        <td>${productSum.toFixed(2)} kr</td>
      </tr>`;

    totalSum += productSum;
  }

  feePrice = calcShippingFee(urlParams.get('city'), totalSum, false)


  // 3.4.4 display table footer with total sum
  dispItems.innerHTML += `
  <thead class='t-order'>
    <th></th>
    <th></th>
    <th>Produktsumma: </th>
    <th>${totalSum.toFixed(2)} kr</th>
  </thead>`;
  dispItems.innerHTML += `
  <thead class='t-order'>
    <th></th>
    <th></th>
    <th>Fraktavgift: </th>
    <th id="shippingFee">${feePrice}kr</th>
  </thead>`;
  dispItems.innerHTML += `
  <thead class='t-bottom-order'>
    <th></th>
    <th></th>
    <th>Total summa: </th>
    <th>${(totalSum + shippingFee).toFixed(2)} kr</th>
  </thead>`;

}
