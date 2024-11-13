<?php
require_once '../Lib/config.php';
require_once '../componentes/input_field.php';
?>
<h1 class="text-center mt-5 mb-5">Registro</h1>

<div class="bg-img">
    <form require class="form_container" method="post" action="Login/registrarse.php" id="registro_form">
        <?php
        new Input_field('Nombre', 'nombre', 'varchar');
        new Input_field('Apellido', 'apellido', 'varchar');
        new Input_field('Nacimiento', 'fecha', 'date');
        new Input_field('Correo', 'email', 'email');
        new Input_field('Contraseña', 'pass', 'password');
        new Input_field('Telefono', 'telefono', 'tel');
        ?>
        <div>
            <button type="submit" class="btn btn-primary mt-5 btn-block w-100 submit_form_button" id="registrar_input_form"> <i class="fas fa-solid fa-arrow-right"></i> Registrar</button>
            <button type="reset" class="btn btn-danger mt-5 btn-block w-100 " id="Borrar"> <i class="fas fa-solid fa-trash"></i> Limpiar</button>
        </div>
    </form>
</div>

<?php require_once '../componentes/newsletter.php'; ?>