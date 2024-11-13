<?php
require_once '../Lib/config.php';
$datos = $_POST;
$enviar = array();
$error = false;
$msj = '';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);

try {

    if ($limpiar_data->validar_data($datos, -1) == true) {
        $parametros = array();
        $parametros['tabla'] = 'usuarios';
        $parametros['campos'] = 'pass,id,nombre';
        $parametros['where'] = "email='" . $datos['email'] . "'";
        $hash = $sql->buscar_datos($parametros)[0];
        if ($hash != null) {
            if (password_verify($datos['pass'], $hash['pass'])) {
                $datos_usuario = array();
                $datos_usuario['id'] = $hash['id'];
                $datos_usuario['nombre'] = $hash['nombre'];
                $_SESSION['usuario'] = $datos_usuario;
                $msj = 'Bienvenido ' . ucfirst($hash['nombre']);
            } else {
                $error = true;
                $msj = 'Ocurrio un error';
            }
        } else {
            $error = true;
            $msj = 'Ocurrio un error';
        }
    } else {
        $error = true;
        $msj = 'Los datos estan vacios';
    }
} catch (\Throwable $th) {
    $error = true;
    $msj = 'Ocurrio un error';
}

Config::send_json($msj,$error);