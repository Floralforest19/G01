
function filterAdresses(){
  let filterInput = document.getElementById('filterInput')
  filterInput.addEventListener('keyup',function (e) {
    let filterPhrase = e.currentTarget.value
    console.log(filterPhrase)
    getAddresses()

  })

}




function getAddresses(){
  let allAddresses = document.querySelectorAll('.shipping_address')
  allAddresses.forEach(address => {
    let city = address.innerHTML
    if (city.toLowerCase() == 'stockholm' ){
      console.log(city)
    }
  });
}
