<?php
require_once '../Lib/config.php';
require_once '../componentes/producto.php';
require_once '../componentes/no_encontrado_filtro.php';
$limpiar_data = new Limpiar_data;
$sql = new Sql($limpiar_data);
$buscar = $limpiar_data->validar_get('buscar');
$param = array();
$param['campos'] = 'prod.nombre,imagen,cat.nombre as categoria,prod.id as id,precio';
$param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria';
$param['where'] = " 1 ";
$data = $sql->buscar_datos($param);
?>

<h1 class="text-center mt-5 mb-5">Buscar</h1>

<h2 class="text-center <?php if(count($data) == 0):?> d-none <?php endif;?>">
    Productos buscados
</h2>
<input type="hidden" class="d-none" id="filter" value="<?php echo $buscar;?>">

<section id="productos_section" class="row row-cols-1 row-cols-md-3 g-4 mt-5 mb-5">
    <?php
    foreach ($data as $key => $value) {
        $producto = new Producto($value['nombre'], $value['imagen'], true, $value['categoria'], $value['id'], $value['precio']);
        $producto->crear_sin_promocion();
    }
    ?>
</section>

<?php
new no_encontrado_filtro('d-none');
?>