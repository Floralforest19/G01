// koppla till DOM
let tableDiv = document.getElementById('table_div')
// skapa tabell
let tableOutput = document.createElement('table')
// lägg till klass till tabell
tableOutput.classList.add('table')
// lägg till nyskapade elementet i diven i DOM
tableDiv.appendChild(tableOutput)
// hämta status knappar
let statusBtns = document.querySelectorAll('.btn__sortStatus')
// spara en senaste global order varje gång man utfört någon form av sortering

// hämta order info från informations fil och kör för att visa alla ordrar första gången
fetch('orders-information.php')
  .then(resp => resp.json())
  .then(order => filterPhrase(order))
  .then(order => setupButtons(order))
  .then(order => showOrders(order))


function setupButtons(order) {
  let statusBtns = document.querySelectorAll('.btn__sortStatus')
  statusBtns.forEach(btn => {
    btn.addEventListener('click',function (event) {
      // vilka ordrar vill användaen se, byt style beroende på vilken knapp som är aktiv
      let whichOrders = 'Alla'
      if(event.currentTarget.id == 'statusNew'){
        whichOrders = 'Ny'
        document.getElementById('statusAll').classList.remove('btn__sortStatus--active')
        document.getElementById('statusNew').classList.add('btn__sortStatus--active')
        document.getElementById('statusActive').classList.remove('btn__sortStatus--active')
      } else if(event.currentTarget.id == 'statusActive'){
        whichOrders = 'Behandlas'
        document.getElementById('statusAll').classList.remove('btn__sortStatus--active')
        document.getElementById('statusNew').classList.remove('btn__sortStatus--active')
        document.getElementById('statusActive').classList.add('btn__sortStatus--active')
      } else {
        whichOrders = 'Alla'
        document.getElementById('statusAll').classList.add('btn__sortStatus--active')
        document.getElementById('statusNew').classList.remove('btn__sortStatus--active')
        document.getElementById('statusActive').classList.remove('btn__sortStatus--active')
      }
      let ordersFiltered1 = order
        if( whichOrders != 'Alla'){
          ordersFiltered1 = order.filter( a => a.status == whichOrders)
        }
        // töm filtrets input varje gång knapp trycks
        let filterInput = document.getElementById('filterInput')
        filterInput.value = ''
        // skriver ut ordarna som uppfyller kraven
        showOrders(ordersFiltered1)
        // ifall användaren vill filtera efter eget input körs filterPhrase
        filterPhrase(ordersFiltered1)
    })
  })
  return order
}

// filtrera ordrar
function filterPhrase(ordersFiltered1) {
  // koppla till input för filtrering
  let filterInput = document.getElementById('filterInput')
  let ordersFiltered2 = ordersFiltered1
  filterInput.addEventListener('input', function (e) {
    let userInput = e.currentTarget.value
    let onlyLetters = /^[a-zA-ZåäöÅÄÖ]*$/.test(userInput)
    if(onlyLetters){
      ordersFiltered2 = ordersFiltered1.filter( order => order.shippingCity.toLowerCase().startsWith(userInput))
      showOrders(ordersFiltered2)
    } else {
      // feedback
      filterInput.value = userInput.substring(0, userInput.length - 1)
      if(userInput.length > 20){
        document.querySelector('.sortFeedback').innerHTML = "Finns ingen stad med så många bokstäver"
      } else {
        document.querySelector('.sortFeedback').innerHTML = "Bara a-ö tillåtet"
      }
    }
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
        <th>Status 
        <button class='sort__btn' id="statusSortAsc">
          <i class="fas fa-angle-up"></i>
        </button>
        <button class='sort__btn' id="statusSortDesc">
          <i class="fas fa-angle-down"></i>
        </button>
        </th>
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
          <td><a href='order-info.php?order_id=${order[i].order_id}'>${order[i].order_id}</a></td>
          <td>${order[i].name}</td>
          <td>${order[i].email}</td>
          <td>${order[i].shippingStreet} ${order[i].shippingZip}<br>
              ${order[i].shippingCity}</td>
          <td>${order[i].time}</td>
          <td>${order[i].totalSum} kr</td>
          <td>${selectStatus}</td>
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
        case 'sumSortAsc' : order.sort(sortSumASC('totalSum'))
        break;
        case 'sumSortDesc' : order.sort(sortSumDESC('totalSum'))
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

function sortSumASC(value){  
  return function(a,b){  
    a[value] = a[value].replace(",","")
    b[value] = b[value].replace(",","")
     if(parseFloat(a[value]) > parseFloat(b[value]))  
        return 1;  
     else if(parseFloat(a[value]) < parseFloat(b[value]))  
        return -1;  
     return 0;  
  }  
}

function sortSumDESC(value){  
  return function(a,b){  
    a[value] = a[value].replace(",","")
    b[value] = b[value].replace(",","")
     if(parseFloat(a[value]) < parseFloat(b[value]))  
        return 1;  
     else if(parseFloat(a[value]) > parseFloat(b[value]))  
        return -1;  
     return 0;  
  }  
}