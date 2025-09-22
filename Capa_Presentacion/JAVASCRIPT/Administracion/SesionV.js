function ValidarS() {
    let usuario = document.getElementById("usuario").value;
    let password = document.getElementById("password").value;

    if(usuario == "" || password == "") {
        alert("Por favor complete todos los campos");
        return false;
    }

    if(usuario <= 0){
        alert("El usuario debe ser un número válido");
        return false;
    }

    return true;
}
/* */