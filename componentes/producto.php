<?php

class Producto
{
    private $titulo = '';
    private $imagen = '';
    private $accion = true;
    private $clase = '';
    private $id = 0;
    private $precio = '';
    private $descripcion = '';

    function __construct($titulo = '', $imagen = '', $accion = true, $clase = '', $id = 0, $precio = '')
    {
        $this->titulo = $titulo;
        $this->imagen = $imagen;
        $this->accion = $accion;
        $this->clase = $clase;
        $this->id = $id;
        $this->precio = $precio;
    }

    public function set_descripcion($descripcion = '')
    {
        $this->descripcion = $descripcion;
    }

    public function crear_sin_promocion()
    {
?>
        <div class="card p-3 sin_promocion producto border-primary <?php echo $this->clase; ?> all">
            <h4 class="card-title mb-3">
                <?php echo $this->titulo; ?>
            </h4>
            <img src="Imagenes/Productos/<?php echo $this->imagen; ?>" class="card-img-top" alt="<?php echo $this->titulo; ?>">
            <div class="card-body">

                <?php
                if (strlen($this->descripcion) > 0): ?>
                    <p class=" h-50"><?php echo $this->descripcion; ?></p>
                <?php endif; ?>

            </div>
            <div class="card-footer">
                <p class="card-text"> Precio: <small class="text-muted monto"> <?php echo $this->precio; ?></small></p>
                <?php if ($this->accion == true && isset($_SESSION['usuario']) == true) : ?>
                    <button onclick="agregar_carro('<?php echo $this->id; ?>')" class="btn btn-primary submit_form_button"><i class="fas fa-solid fa-cart-plus"></i> Agregar al Carrito ></button>
                <?php
                endif;
                ?>
            </div>
        </div>
    <?php
    }

    public function crear_con_promocion($descuento = 0)
    {
    ?>
        <div class="card mb-3 producto border-primary <?php echo $this->clase; ?>" style="max-width: 540px;">
            <h4 class="card-title text-center mt-3 ml-3"> <?php echo $this->titulo; ?></h4>
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="Imagenes/Productos/<?php echo $this->imagen; ?>" class="img-fluid rounded-start mt-3 mb-5" alt="<?php echo $this->titulo; ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">

                        <p class="card-text"> Precio: <small class="text-muted monto"> <?php echo $this->precio; ?></small></p>
                        <p class="card-text"> Con la promocion: <small class="text-muted monto"> <?php echo ($this->precio - $descuento) ?></small></p>
                    </div>
                    <?php if ($this->accion == true && isset($_SESSION['usuario']) == true) { ?>
                        <div class="card-footer">
                        <button onclick="agregar_carro('<?php echo $this->id; ?>')" class="btn btn-primary submit_form_button"><i class="fas fa-solid fa-cart-plus"></i> Agregar al Carrito ></button>
                        </div>
                    <?php
                    } ?>



                </div>
            </div>
        </div>
<?php
    }
}
?>