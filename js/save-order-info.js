function sendProductInfo() {
  // hämta korgen från local storage
  let cartFromStorage = localStorage.getItem('shoppingCart')
  // hämta fältet från formuläret och spara produkt infon i den
  document.getElementById('order_info').value = cartFromStorage
}
sendProductInfo()