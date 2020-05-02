// koppla till DOM
let tableDiv = document.getElementById('table_div')
// skapa tabell
let tableOutput = document.createElement('table')
// lägg till klass till tabell
tableOutput.classList.add('table')
// lägg till nyskapade elementet i diven i DOM
tableDiv.appendChild(tableOutput)
// spara en senaste global order varje gång man utfört någon form av sortering

// hämta order info från informations fil och kör för att visa alla ordrar första gången
fetch('orders-done-info.php')
  .then(resp => resp.json())
  .then(order => filterPhrase(order))
  .then(order => showOrders(order))

// filtrera ordrar
function filterPhrase(ordersFiltered1) {
  // koppla till input för filtrering
  let filterInput = document.getElementById('filterInput')
  let ordersFiltered2 = ordersFiltered1
  filterInput.addEventListener('input', function (e) {
    let userInput = e.currentTarget.value
      ordersFiltered2 = ordersFiltered1.filter( order => order.shippingCity.toLowerCase().startsWith(userInput))
      showOrders(ordersFiltered2)
  })
  return ordersFiltered2;
}

// funktion som ritar ut ordrar i DOM
function showOrders(order) {
  let table = `
      <thead>
        <th>Order-id</th>
        <th>Namn</th>
        <th>E-mail</th>
        <th>Leveransadress</th>
        <th>Tid/Datum 
          <button class='sort__btn' id="timeSortAsc">
            <i class="fas fa-angle-up"></i>
          </button>
          <button class='sort__btn' id="timeSortDesc">
            <i class="fas fa-angle-down"></i>
          </button>
        <th>Summa
        <button class='sort__btn' id="sumSortAsc">
          <i class="fas fa-angle-up"></i>
        </button>
        <button class='sort__btn' id="sumSortDesc">
          <i class="fas fa-angle-down"></i>
        </button>
        <th>Status</th>
      </thead>`
  for (let i = 0; i < order.length; i++) {
      table +=
        `<tr>
          <td><a href='order-info-done.php?order_id=${order[i].order_id}'>${order[i].order_id}</a></td>
          <td>${order[i].name}</td>
          <td>${order[i].email}</td>
          <td>${order[i].shippingStreet} ${order[i].shippingZip}<br>
              ${order[i].shippingCity}</td>
          <td>${order[i].time}</td>
          <td>${order[i].totalSum} kr</td>
          <td>Slutförd</td>
        </tr>`
  }
  tableOutput.innerHTML = table
  sortOrders(order)
  return order
}

// hämta order och sortera om ordern beroende på vilken knapp som är tryckt
function sortOrders(order) {
  let sortBtns = document.querySelectorAll('.sort__btn')
  sortBtns.forEach(btn => {
    btn.addEventListener('click',function (e) {
      let sortMe = e.currentTarget.id
      switch (sortMe) {
        case 'timeSortAsc' : order.sort(sortByKeyAndOrderASC('time'))  
        break;
        case 'timeSortDesc' : order.sort(sortByKeyAndOrderDESC('time'))
        break;
        case 'sumSortAsc' : order.sort(sortByKeyAndOrderASC('totalSum'))
        break;
        case 'sumSortDesc' : order.sort(sortByKeyAndOrderDESC('totalSum'))
        break;
        case 'statusSortAsc' : order.sort(sortByKeyAndOrderASC('status'))
        break;
        case 'statusSortDesc' : order.sort(sortByKeyAndOrderDESC('status'))
        break;
      }
      // skicka tillbaka till början
      showOrders(order)
    })
  });
}

function sortByKeyAndOrderASC(value){  
  return function(a,b){  
     if(a[value] > b[value])  
        return 1;  
     else if(a[value] < b[value])  
        return -1;  
     return 0;  
  }  
}

function sortByKeyAndOrderDESC(value){  
  return function(a,b){  
     if(a[value] < b[value])  
        return 1;  
     else if(a[value] > b[value])  
        return -1;  
     return 0;  
  }  
}