/******
 Calculate which zip-code who will receive free shipping
 *****/


var shippingFeeCity = function (shipping_adress_city) {
   shipping_adress_city = shipping_adress_city.toUpperCase();
   let shippingFeeCity = document.getElementById("shippingFee")
   if (shipping_adress_city == 'STOCKHOLM') {
      shippingFeeCity.innerHTML = '0kr';
   } else {
      shippingFeeCity.innerHTML = '50kr';
   }
}