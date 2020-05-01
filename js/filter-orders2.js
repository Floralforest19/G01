// koppla till DOM
let tableDiv = document.getElementById('table_div')
// skapa tabell
let tableOutput = document.createElement('table')
// lägg till klass till tabell
tableOutput.classList.add('table')
// lägg till nyskapade elementet i diven i DOM
tableDiv.appendChild(tableOutput)

// filtrera ordrar
function filterPhrase() {
  // koppla till input för filtrering
  let filterInput = document.getElementById('filterInput')
  let statusForm = document.getElementById('statusForm')
  console.log(statusForm)
  filterInput.addEventListener('input', function (e) {
    let test = e.currentTarget.value
    fetch('orders-information.php')  
    .then( resp => resp.json() ) // konverterar till .json
    .then( function(order) {
      let ordersFiltered = order.filter( a => a.shippingCity.toLowerCase().startsWith(test))
      showOrders(ordersFiltered) 
    })
  })
}
// filtrerar på sta utifrån input från användare
filterPhrase()

// hämta order info från informations fil
fetch('orders-information.php')
  .then(resp => resp.json())
  .then(order => showOrders(order))

// funktion som ritar ut ordrar i DOM
function showOrders(order) {
  let table = `
      <thead>
        <th>Order-id</th>
        <th>Namn</th>
        <th>E-mail</th>
        <th>Leveransadress</th>
        <th>Tid/Datum</th>
        <th>Sum</th>
        <th>Status</th>
      </thead>`
  for (let i = 0; i < order.length; i++) {
      selectStatus =
        `<form method='post' action='orders-update.php?order_id=${order[i].order_id}'>
        <select name='statusSelect' id='statusSelect'>`
      if (order[i].status == 'Ny') {
        selectStatus += `
        <option value='active' selected>Ny</option>
        <option value='in progress'>Behandlas</option>
        <option value='done'>Slutförd</option>`
      } else if (order[i].status == 'Behandlas') {
        selectStatus += `
          <option value='active'>Ny</option>
          <option value='in progress' selected>Behandlas</option>
          <option value='done'>Slutförd</option>`
      }
      selectStatus += `</select><input type='submit' value='Sätt status'></form>`
      table +=
        `<tr>
          <td>${order[i].order_id}</td> 
          <td>${order[i].name}</td> 
          <td>${order[i].email}</td> 
          <td>${order[i].shippingStreet} ${order[i].shippingZip}<br>
              ${order[i].shippingCity}</td> 
          <td id="orderByTime">${order[i].time}</td> 
          <td id="orderBySum">SUMMA</td> 
          <td id="orderByStatus">${selectStatus}</td> 
        </tr>`
        // lägga till summa
  }
  tableOutput.innerHTML = table
}