<?php
require_once '../Lib/config.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);
$datos = $_POST;
$error = false;
$msj = '';

try {
    $email = $limpiar_data->validar_email($datos['email']);
    $parametros = array();

    if (isset($datos['id']) == false && $email == true) {
        $parametros['campos'] = 'count(*) as cantidad';
        $parametros['tabla'] = 'newsletter';
        $parametros['where'] = "email='" . $datos['email'] . "'";
        $buscar_usuario = $sql->buscar_datos($parametros);
    } else {
        $error = true;
        $msj = 'Ocurrio un error';
    }

    if (intval($buscar_usuario[0]['cantidad']) == 0) {
        $datos['activo'] = 1;
        $parametros = array();
        $parametros['tabla'] = 'newsletter';

        if ($error == false) {

            $parametros['values'] = $datos;
            $resultado = $sql->insertar($parametros);
            $msj = 'Se guardo el newsletter';

            if ($resultado == false) {
                $error = true;
                $msj = 'Ocurrio un error';
            }
        }
    }
} catch (\Throwable $th) {
    $error = true;
    $msj = 'Ocurrio un error';
}
Config::send_json($msj, $error);
