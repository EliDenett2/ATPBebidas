<?php
require_once '../Lib/config.php';
require_once '../componentes/producto.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);
$limit = $limpiar_data->validar_get('limit');
if (is_numeric($limit) == false) {
    $limit = 5;
} else {
    if ($limit == 0) {
        $limit = 5;
    }
}
?>
<section class="row filtros">
    <h3 class="col-6 pl-5 recomendacion">
    Conoce nuestros productos disponibles
    </h3>
</section>
<section id="productos_section_2" class="row row-cols-1 row-cols-md-3 g-4 mt-5 scroll height_35em">
    <?php
    $param = array();
    $param['campos'] = 'prod.nombre,imagen,cat.nombre as categoria,prod.id as id,precio,descripcion';
    $param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria';
    $param['where'] = ' 1 limit ' . $limit;
    foreach ($sql->buscar_datos($param) as $key => $value) {
        $producto = new Producto($value['nombre'], $value['imagen'], true, $value['categoria'], $value['id'], $value['precio']);
        $producto->set_descripcion($value['descripcion']);
        $producto->crear_sin_promocion();
    }
    ?>
</section>

<div class="d-flex justify-content-center mt-5">
    <button id="cargar_mas" class="btn btn-primary submit_form_button" onclick="cargar_mas(10)">Cargar mas</button>
</div>