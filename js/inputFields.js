const inputField = document.getElementById("linha-digitavel");

inputField.addEventListener("input", function() {
    let inputValue = inputField.value;
    inputValue = inputValue.replace(/\D/g, '');
    inputValue = inputValue.replace(/^(\d{3})(\d{1})(\d{5})(\d{1})(\d{6})(\d{4})(\d{1})(\d{10})(\d{1})(\d{15})(\d{1}).*/, 
    '$1 $2 $3 $4 $5 $6 $7 $8 $9 $10 $11');
    inputField.value = inputValue;
});
