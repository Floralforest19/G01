/******
 Calculate which zip-code who will receive free shipping
 *****/

let shipping_adress_city = `${city}`
let shippingAmount = `${amount}`

var shippingFeeCity = function (shipping_adress_city) {
   shipping_adress_city = shipping_adress_city.toLowerCase();
   if (shipping_adress_city == 'STOCKHOLM') {
      alert('Grattis du får gratis frakt');
   } else {
      return 50;
   }
}