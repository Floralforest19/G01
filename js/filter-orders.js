
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