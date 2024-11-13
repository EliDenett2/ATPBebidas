var newsletter_form = document.getElementById("newsletter_form");

newsletter_form.addEventListener("submit", newsletter_form_submit);


function newsletter_form_submit(event) {
    try {
        event.preventDefault();

        var formData = new FormData(newsletter_form);

        fetch(newsletter_form.action, {
                method: newsletter_form.method,
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
                if (resp.error == false) {
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