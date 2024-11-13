var myform = document.getElementById("registro_form");

myform.addEventListener("submit", submitForm);

function submitForm(event) {
    try {
        event.preventDefault();

        var formData = new FormData(myform);

        fetch(myform.action, {
                method: myform.method,
                body: formData,
            })
            .then((response) => {
                if (!response.ok) {
                    appendAlert('Ocurrio un error', 'danger');
                }
                return response.json();
            })
            .then((resp) => {
                appendAlert(resp.msj, resp.estado);
                if(resp.error == false){
                    window.location = 'index.php';
              }
            })
            .catch((error) => {
                error_mensaje(error);
            });
    } catch (error) {
        error_mensaje(error);
    }
}