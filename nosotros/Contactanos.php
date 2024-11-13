<?php
require_once '../Lib/config.php';
require_once '../componentes/input_field.php';
?>

<h1 class="text-center mt-5 mb-5">Contactanos</h1>

<div class="bg-img mb-5">
    <form class="form_container" method="post" action="nosotros/procesar_contacto.php" id="form_contacto">
        <?php
        new Input_field('Correo', 'email', 'email');
        new Input_field('Nombre y apellido', 'apellido_nombre', 'text');
        new Input_field('Mensaje', 'mensaje', 'textarea');
        ?>
        <div>
        <button type="submit" class="btn btn-primary mt-5 btn-block w-100 submit_form_button" id="contacto_enviar_form"><i class="fas fa-solid fa-arrow-right"></i>  Enviar</button>
        <button type="reset" class="btn btn-danger mt-5 btn-block w-100 " id="Borrar"> <i class="fas fa-solid fa-trash"></i> Limpiar</button>
        </div>
    </form>
</div>


<?php require_once '../componentes/newsletter.php'; ?>