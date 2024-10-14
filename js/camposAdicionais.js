function adicionarCampo(campo, container) {
    var div = document.getElementById(container);
    var novoCampo = document.createElement("div");
    novoCampo.innerHTML = ' <input name="' + campo + '" type="text">';
    div.appendChild(novoCampo);
}