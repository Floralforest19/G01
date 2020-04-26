function validateShoppingCartQuantity(chosenQuantityByUser, quantityInStock) {
  if (isNaN(chosenQuantityByUser)) {
    return false;
  }

  if (isNaN(quantityInStock)) {
    return false;
  }

  if (chosenQuantityByUser > quantityInStock) {
    return false;
  }

  if (chosenQuantityByUser < 1) {
    return false;
  }
  //All validering gick bra
  return true;
}
