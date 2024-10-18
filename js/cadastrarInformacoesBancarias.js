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
    showInputs();
});

