function validateShoppingCartQuantity(chosenQuantityByUser, quantityInStock) {
  if (!Number.isInteger(chosenQuantityByUser)) {
    return false;
  }

  if (!Number.isInteger(quantityInStock)) {
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
