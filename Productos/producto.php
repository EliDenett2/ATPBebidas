<?php
require_once '../Lib/config.php';
require_once '../componentes/producto.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);

?>
<h1 class="text-center mt-5 mb-5">Nuestros productos</h1>

<h3 class="ml-5 pl-5 filtros">
Los productos mas solicitados
</h3>

<section id="productos_section" class="row row-cols-1 row-cols-md-3 g-4 mt-5 scroll height_35em">
    <?php
    $param = array();
    $param['campos'] = 'prod.nombre,imagen,cat.nombre as categoria,prod.id as id,precio';
    $param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria';
    $param['where'] = " 1 ORDER BY RAND() LIMIT 5";
    $data = $sql->buscar_datos($param);

    foreach ($data as $key => $value) {
        $producto = new Producto($value['nombre'], $value['imagen'], true, $value['categoria'], $value['id'], $value['precio']);
        $producto->crear_sin_promocion();
    }
    ?>
</section>
<div id="cargar_productos"></div>
<?php require_once '../componentes/newsletter.php'; ?>