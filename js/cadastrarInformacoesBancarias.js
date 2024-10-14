 function formatCNPJ(inputElement) {
    let inputValue = inputElement.value;
    inputValue = inputValue.replace(/\D/g, '');
    inputValue = inputValue.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, '$1.$2.$3/$4-$5'); 
    inputElement.value = inputValue;
} 

function showInputs() {
    var select = document.getElementById("meio-pagamento");
    var tedDoc = document.getElementById("ted-doc");
    var pix = document.getElementById("pix");

    if (select.value === "Pix") {
        tedDoc.style.display = "none";
        pix.style.display = "block";
    } else {
        tedDoc.style.display = "block";
        pix.style.display = "none";
    }
}

// Run right after the page is loaded for the first time
document.addEventListener("DOMContentLoaded", function() {
    // formatCNPJ(document.getElementById("cnpj"));
    showInputs();
});

