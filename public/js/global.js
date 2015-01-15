function SelectValueFromList(listItem, myField) {
	pickValue = document.getElementById(listItem).value
    document.getElementById(myField).value = pickValue;
}
function SelectListFromValue(myField, listItem) {
     var fieldValue = document.getElementById(myField).value,
         someInt = 0,
         selectValue = document.getElementById(listItem);
     document.getElementById(listItem).selectedIndex = 0;
     while ((selectValue.options[someInt].value !== fieldValue) && (someInt < selectValue.options.length - 1)) {someInt ++; }
     if (selectValue.options[someInt].value === fieldValue) {document.getElementById(listItem).selectedIndex = someInt; }
}