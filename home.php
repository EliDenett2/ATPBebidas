<?php
require_once 'Lib/config.php';
require_once 'componentes/producto.php';
require_once 'componentes/no_encontrado_filtro.php';
$sql = new Sql(new Limpiar_data);
?>

<section id="carouselExample" class="carousel slide w-75 h-50 mt-5 ml-5">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="imagenes/top-panel.png" class="d-block w-100" alt="Primera imagen">
        </div>
        <div class="carousel-item">
            <img src="imagenes/top-panel.png" class="d-block w-100" alt="Segunda imagen">
        </div>
        <div class="carousel-item">
            <img src="imagenes/top-panel.png" class="d-block w-100" alt="Tercera imagen">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</section>

<div class="d-flex justify-content-center">
    <h3 class="text-center mt-3">¡Encuentra la bebida que mejor se adapte a ti!</h3>
</div>

<section class="row filtros">
    <h3 class="col-6 pl-5 recomendacion">
        Recomendaciones para ti
    </h3>
    <ul id="lista_filtros" class="list-group list-group-horizontal-sm mt-5 mb-5 col-auto">
        <li onclick="filtrar('all')" class=" btn btn-button filtro_item mt-3 submit_form_button">Todos nuestros productos</li>
        <?php
        $param = array();
        $param['campos'] = 'nombre,id';
        $param['tabla'] = 'categorias';
        $param['where'] = ' 1 ';
        foreach ($sql->buscar_datos($param) as $key => $value) {
            echo '<li onclick=' . "filtrar('" .  $value['nombre'] . "')" . ' class=" btn btn-button filtro_item mt-3 submit_form_button">' . $value['nombre'] . '</li>';
        }
        ?>
    </ul>
<?php
new no_encontrado_filtro('d-none');
?>
</section>

<section id="productos_section" class="row row-cols-1 row-cols-md-3 g-4 mt-5 scroll height_60em">
    <?php
    $param = array();
    $param['campos'] = 'prod.nombre,imagen,cat.nombre as categoria,prod.id as id,precio';
    $param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria';
    $param['where'] = ' 1 ';
    foreach ($sql->buscar_datos($param) as $key => $value) {
        $producto = new Producto($value['nombre'], $value['imagen'], true, $value['categoria'], $value['id'],$value['precio']);
        $producto->crear_sin_promocion();
    }
    ?>
</section>

<section class="row ml-3 mr-3 mt-3 paddin_1_left_em w-100 mb-5">
    <img class="col-6 w-50 h-50 img-fluid" src="imagenes/left-instructors.png" alt="texto">
    <img class="col-6 img-fluid" src="imagenes/imagen 3.png" alt="imagen de cata">
</section>

<h3 class="text-center mt-5">Promociones y descuentos</h3>
<section class="row row-cols-1 row-cols-md-3 g-4 mt-3 scroll" id="promociones_descuentos">

    <?php
    $param = array();
    $param['campos'] = 'prod.nombre,prom.imagen as imagen,cat.nombre as categoria,prod.id as id,precio,descuento';
    $param['tabla'] = 'productos prod inner join categorias cat on cat.id = prod.id_categoria inner join promociones prom on prom.id_producto = prod.id';
    $param['where'] = ' prom.activo=1 ';
    foreach ($sql->buscar_datos($param) as $key => $value) {
        $precio = $value['precio'];
        $descuento = ($value['descuento'] / 100) * $precio;
        $producto = new Producto($value['nombre'], $value['imagen'], true, $value['categoria'], $value['id'],$precio);
        $producto->crear_con_promocion($descuento);
    }
    ?>
</section>

<?php require_once 'componentes/newsletter.php'; ?>

<footer class="navbar navbar-expand-lg navbar-light bg-light mt-5">
<a href="https://www.instagram.com/atp_bebidasimportadas_/" target="_blank" class="btn btn-primary"> Instagram </a>    
</footer>