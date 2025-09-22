function Validar(){
    let salaInput = document.querySelector("input[name='nro_Sala']");
    let fechaInput = document.querySelector("input[name='fecha']");
    
    console.log(salaInput, fechaInput);

    let sala = salaInput.value;
    let fecha = fechaInput.value;

    if(sala == "" || isNaN(sala) || parseInt(sala) <= 0){
        alert("Ingrese un ID de sala válido");
        return false;
    }

    if(fecha == ""){
        alert("Seleccione una fecha");
        return false; 
    }

    return true;
}
