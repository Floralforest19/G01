/******
 Calculate which zip-code who will receive free shipping
 *****/
//"shippingFee"
var calcShippingFee = function (shipping_adress_city, sum, id = false) {

   shipping_adress_city = (shipping_adress_city) ? shipping_adress_city.toUpperCase() : false;
   var price = 0;

   if (shipping_adress_city == 'STOCKHOLM' || sum >= 500) {
      price = 0;
   } else {
      price = 50;
   }

   if (id) {
      let shippingFeeCity = document.getElementById(id);
      shippingFeeCity.innerHTML = price + "kr";
   } else {
      return price;
   }

}