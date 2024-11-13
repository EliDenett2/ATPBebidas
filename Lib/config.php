<?php
error_reporting(1);
session_start();
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once 'sql.php';
require_once 'Limpiar_data.php';

class Config
{
    public static $ruta = 'http://localhost/ATpBebida/';
    public static function send_json($msj = '',$error = false,$data = array())
    {
        $info = array();
        $info['msj'] = $msj;
        if ($error == false) {
            $info['estado'] = 'success';
        } else {
            $info['estado'] = 'danger';
        }
        $info['error'] = $error;
        if(empty($data) == false){
            $info['data'] = $data;
        }
   
        header('Content-Type: application/json');
        echo json_encode($info, JSON_FORCE_OBJECT);
    }
}
