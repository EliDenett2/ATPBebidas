<?php
require_once '../Lib/config.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);
$id = $limpiar_data->validar_get('id');
$error = false;
$msj = '';
$datos = array();
$items = $_SESSION['items'];
if (isset($_SESSION['usuario']) == true) {

    if (is_numeric($id) == true) {
        $param = array();
        $param['campos'] = 'prod.nombre as nombre,imagen,cat.nombre as categoria,prod.id as id,precio,descripcion';
        $param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria';
        $param['where'] = "prod.id='" . $id . "'";
        $datos = $sql->buscar_datos($param)[0];
        $buscar = array();
        $buscar['campos'] = 'descuento';
        $buscar['tabla'] = 'promociones';
        $buscar['where'] = "id_producto='" . $id . "'";
        $descuento = $sql->buscar_datos($buscar)[0];
        if($descuento != null){
            $resta = ($descuento['descuento'] / 100) * $datos['precio'];
            $datos['precio'] -= $resta;
        }
        $item_mercado_pago = array();
        $item_mercado_pago['precio'] = $datos['precio'];
        $item_mercado_pago['id_item'] = $datos['id'];
        $item_mercado_pago['cantidad'] = 1;
        $item_mercado_pago['nombre'] = $datos['nombre'];
        $_SESSION['items'][count($items)] = $item_mercado_pago;
        $msj = 'Producto agregado';
    } else {
        $error = true;
        $msj = 'Ocurrio un error';
    }
} else {
    $error = true;
    $msj = 'Ocurrio un error';
}
Config::send_json($msj, $error,$datos);
