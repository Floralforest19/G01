
function filterAdresses(){
  let filterInput = document.getElementById('filterInput')
  filterInput.addEventListener('keyup',function (e) {
    let filterPhrase = e.currentTarget.value
    console.log(filterPhrase)
    getAddresses(filterPhrase)
  })
}
function getAddresses(filterPhrase){
  let allAddresses = document.querySelectorAll('.shipping_address')
  let cityArray = []
  allAddresses.forEach(address => {
    let city = address.innerHTML.toLowerCase()
    cityArray.push(city)
  });
  cityArray = cityArray.filter(filterPhrase)
}
filterAdresses()

const products = [
  'Banana',
  'Apple',
  'Pineapple',
  'Pear',
  'Strawberry'
]

const filterField = document.querySelector('#filterInput')
filterField.addEventListener('input', function(event) {
  const filteredProducts = products.filter(function(product) {
    return product.toLowerCase().includes(
      event.currentTarget.value.toLowerCase()
    )
  })
  listProducts(filteredProducts)
})

function listProducts(productList) {
  const elementList = document.querySelector('#products')
  elementList.innerHTML = ''
  productList.forEach(function(product) {
    const li = document.createElement('li')
    li.textContent = product
    elementList.appendChild(li)
  })
}

listProducts(products)