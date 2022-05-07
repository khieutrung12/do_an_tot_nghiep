const { replace } = require("lodash");

function ConfirmDelete(message)
{
  return confirm(message);
}
CKEDITOR.replace('ckeditor');
CKEDITOR.replace('add_product_ckeditor');
CKEDITOR.replace('desc_product_ckeditor');

function stepper(id)
{
  const myArray = id.split("_");
  let _id = myArray[1];
  let myInput = document.getElementById("input-number_" + _id);
  let min = myInput.getAttribute("min");
  let max = myInput.getAttribute("max");
  let value = myInput.getAttribute("value");

  if (id == ("increment_" + _id)) {
    newValue = parseInt(value) + 1;
  }

  if (id == ("decrement_" + _id)) {
    newValue = parseInt(value) - 1;
  }
 
  if(newValue >= min && newValue <= max){
    myInput.setAttribute("value", newValue);
  }
}
