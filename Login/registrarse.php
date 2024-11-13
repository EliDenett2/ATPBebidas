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
                $parametros['tabla'] = 'usuarios';
                $parametros['where'] = "email='" . $datos['email'] . "'";
                $buscar_usuario = $sql->buscar_datos($parametros);
            }

            if (intval($buscar_usuario[0]['cantidad']) == 0) {
                if ($limpiar_data->validar_pass($datos['pass']) == true) {
                    $datos['pass'] = password_hash($datos['pass'], PASSWORD_DEFAULT);
                    $parametros = array();
                    $parametros['tabla'] = 'usuarios';
                    $cumpleanos = new DateTime($datos['fecha']);
                    $hoy = new DateTime();
                    $annos = $hoy->diff($cumpleanos);
                    if($annos->y < 18){
                        $error = true;
                        $msj = 'No podes registrarte porque sos menor de edad';
                    }
                    if ($error == false) {
                        $parametros['values'] = $datos;
                        $resultado = $sql->insertar($parametros);
                        $msj = 'Usuario registrado';

                        if ($resultado == false) {
                            $error = true;
                            $msj = 'Ocurrio un error';
                        }
                    }
                } else {
                    $error = true;
                    $msj = 'Tu contraseña no es segura';
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

Config::send_json($msj,$error);
