function validateShoppingCartQuantity(chosenQuantityByUser, quantityInStock) {
  if (chosenQuantityByUser > quantityInStock) {
    return false;
  }

  if (chosenQuantityByUser < 1) {
    return false;
  }
  //All validering gick bra
  return true;
}
