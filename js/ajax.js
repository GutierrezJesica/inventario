const formularios_ajax=document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault();

    let enviar=confirm("Quiero enviar el formulario");

    if(enviar==true) {

        let data= new FormData(this);
        let method=this.getAtribute("method");
        let action=this.getAtribute("action");

        let encabezados= new Headers();

        let config={
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta => {
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        });
    }
}

formularios_ajax.forEach(formulario => {
    formularios_ajax.addEventListener("submit",enviar_formulario_ajax);
});