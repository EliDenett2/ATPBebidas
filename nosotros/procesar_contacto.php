<?php
require_once '../Lib/config.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);
$datos = $_POST;
$error = false;
$msj = '';
try {
    if ($limpiar_data->validar_data($datos, -1) == true) {

        if ($limpiar_data->validar_email($datos['email']) == true) {
            $parametros = array();

            if (isset($datos['id']) == false) {
                $parametros['campos'] = 'count(*) as cantidad';
                $parametros['tabla'] = 'contactos';
                $parametros['where'] = "email='" . $datos['email'] . "'";
                $buscar_usuario = $sql->buscar_datos($parametros);
            }

            if (intval($buscar_usuario[0]['cantidad']) == 0) {

                $parametros = array();
                $parametros['tabla'] = 'contactos';
                if ($error == false) {
                    $parametros['values'] = $datos;
                    $resultado = $sql->insertar($parametros);
                    $msj = 'Mensaje guardado';

                    if ($resultado == false) {
                        $error = true;
                        $msj = 'Ocurrio un error';
                    }
                }
            } else {
                $error = true;
                $msj = 'Ocurrio un error';
            }
        } else {
            $error = true;
            $msj = 'El email es invalido';
        }
    } else {
        $error = true;
        $msj = 'Los datos estan vacios';
    }
} catch (\Throwable $th) {
    $error = true;
    $msj = 'Ocurrio un error';
}

Config::send_json($msj, $error);
