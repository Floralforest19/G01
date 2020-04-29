/******
 Calculate which zip-code who will receive free shipping
 *****/
//"shippingFee"
var calcShippingFee = function (shipping_adress_city, sum, id = false) {
   if (!shipping_adress_city)
      return "50"; //Default value

   shipping_adress_city = shipping_adress_city.toUpperCase();
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