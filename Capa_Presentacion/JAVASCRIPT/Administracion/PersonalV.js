
function ValidarP(){
    let ci = document.getElementById("ci").value;
    let nombre = document.getElementById("nombre").value;
    let salario = document.getElementById("salario").value;

    if(ci === "" || nombre === "" || salario === ""){
        alert("Complete todos los campos.");
        return false;
    }

    if(ci.length < 6){
        alert("CI demasiado corto.");
        return false;
    }

    if(isNaN(salario) || salario <= 0){
        alert("Salario inválido.");
        return false;
    }

    return true;
}

function ValidarA(){
    let id = document.getElementById("idAsistencia").value;
    let entrada = document.getElementById("horaEntrada").value;
    let salida = document.getElementById("horaSalida").value;
    let fecha = document.getElementById("fecha").value;

    if(id=="" || entrada=="" || salida=="" || fecha==""){
        alert("Complete todos los campos de asistencia.");
        return false;
    }

    if(salida <= entrada){
        alert("Hora de salida debe ser mayor que hora de entrada.");
        return false;
    }

    return true;
}

function ValidarB(){
    let id = document.getElementById("idBuscar").value;
    if(id==""){
        alert("Ingrese ID para buscar historial.");
        return false;
    }
    return true;
}
