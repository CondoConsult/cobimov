function formatPhoneNumber(inputElement) {
    let inputValue = inputElement.value;
    inputValue = inputValue.replace(/\D/g, '');
    inputValue = inputValue.replace(/^(\d{2})(\d{4})(\d{4}).*/, '$1 $2 $3');
    inputElement.value = inputValue;
}

function formatPhone(inputElement) {
    let inputValue = inputElement.value;
    inputValue = inputValue.replace(/\D/g, '');
    inputValue = inputValue.replace(/^(\d{2})(\d{5})(\d{4}).*/, '$1 $2 $3');
    inputElement.value = inputValue;
}

const telefone = document.getElementById("telefone");
telefone.addEventListener("input", () => formatPhoneNumber(telefone));

const telefoneMoradores = document.getElementById("telefone-moradores");
telefoneMoradores.addEventListener("input", () => formatPhoneNumber(telefoneMoradores));

const celular = document.getElementById("celular");
celular.addEventListener("input", () => formatPhone(celular));

const celularMoradores = document.getElementById("celular-moradores");
celularMoradores.addEventListener("input", () => formatPhone(celularMoradores));