<?php
require_once 'Lib/config.php';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
    <meta name="keywords" content="bebidas,tp,facultad,">
    <meta name="author" content="Elizabeth Dennett">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pagina web de venta de bebidas alcohólicas">
    <meta property="og:description" content="Pagina web de venta de bebidas alcohólicas">
    <meta property="og:title" content="ATP Bebidas">
    <meta property="og:image" content="">
    <title>ATP Bebidas</title>
    <link href="estilos/font_awsome.css" rel="stylesheet">
    <script type="text/javascript" src="js/fontawesome.js" crossorigin="anonymous"></script>
    <link href="estilos/estilo.css" rel="stylesheet">
    <link rel="shortcut icon" href="imagenes/icono.ico">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="estilos/boostrap.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body id="body" onload="navegar('Home',this)">

    <nav class="navbar navbar-expand-lg bg-transparent mt-5 mb-3 ml-5">
        <div class="container-fluid">
            <a class="navbar-brand ml-5 fw-bold" onclick="navegar('Home',this)">
                <img src="Imagenes/logo.png" alt="logo" class="img-fluid">
            </a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button onclick="navegar('Productos/producto',this)" class="nav-link"> <i class="fas fa-solid fa-wine-glass"></i> Nuestros productos</button>
                    </li>

                    <li class="nav-item">
                        <button onclick="navegar('nosotros/Contactanos',this)" class="nav-link"> <i class="fas fa-users"></i> Contactanos</button>
                    </li>

                    <li class="nav-item">
                        <button onclick="navegar('nosotros/nosotros',this)" class="nav-link"> <i class="fas fa-users"></i> Sobre nosotros</button>
                    </li>

                    <?php if (isset($_SESSION['usuario']) == false) { ?>
                        <li class="nav-item">
                            <button onclick="navegar('Login/registro',this)" class="nav-link"> <i class="fas fa-sign-in-alt mr-3"></i> Registro</button>
                        </li>

                        <li class="nav-item">
                            <button onclick="navegar('Login/Login',this)" class="nav-link"> <i class="fas fa-sign-in-alt mr-3"></i> Iniciar sesion</button>
                        </li>
                </ul>

            </div>
        <?php
                    }
                    require_once 'componentes/buscar.php';
                    if (isset($_SESSION['usuario']) == true) { ?>
            <div class="vl"></div>
            <div class="dropdown">
                <a class="btn submit_form_button dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['usuario']['nombre']; ?>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                    <li class="nav-item">
                        <button class="nav-link text-white text-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> <i class="fas fa-solid fa-cart-plus"></i> Mis pedidos</button>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <button onclick="navegar('Login/cerrar_session',this)" class="nav-link text-white text-center"> <i class="fas fa-sign-out-alt"></i> Salir</button>
                    </li>
                </ul>
            </div>
        <?php } ?>
        </div>
    </nav>
    <hr>

    <div id="alert"></div>
    <main id="contenido"></main>
    <?php if (isset($_SESSION['usuario']) == true) { ?>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <section id="carrito_compra" class="container mt-5 p-3 rounded cart scroll h-50">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel" class="text-center">Carrito de compra</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="row no-gutters offcanvas-body">
                    <div class="col-md-8">
                        <div id="productos_carro_compra" class="product-details mr-2">
                            <div class="d-flex justify-content-between">
                                <span>Tenes <span id="cantidad_productos_carrito"> 0 </span> productos</span>
                            </div>
                        </div>
            </section>
            <div class="ml-5">
                <p class="filtros text-center col-6">Total: <span id="total"></span></p>
                <a class="btn btn-primary submit_form_button filtros col-6 btn-block">Ir a pagar ></a>
            </div>
        </div>
    <?php
    } ?>
</body>

<script>
    var filtro = '';
    var precio = 0;
    var precios = [];

    function buscar_nav() {
        try {
            filtro = "buscar=" + document.getElementById('buscar_input_nav').value;
            navegar('buscar/buscar', this);
        } catch (error) {
            error_mensaje(error);
        }
    }

    function convertir_dinero(monto) {
        var resultado = 0;
        try {
            let USDollar = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            resultado = USDollar.format(monto).replace(',', '.');
            var dividir = resultado.split('.');
            resultado = dividir[0] + '.' + dividir[1];
        } catch (error) {
            error_mensaje(error);
        }
        return resultado;
    }

    const alertPlaceholder = document.getElementById('alert')
    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            `<div  class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button id="mensaje" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('')
        alertPlaceholder.append(wrapper)
    }
    <?php if (isset($_SESSION['usuario']) == true) { ?>

        function agregar_carro(id) {
            try {
                fetch('Productos/agregar_producto.php?id=' + id)
                    .then((response) =>
                        response.json())
                    .then((data) => {
                        appendAlert(data.msj, data.estado);
                        if (data.estado == 'success') {
                            precios.push(Number.parseInt(data.data.precio));
                            var texto = '<div class="d-flex justify-content-between align-items-center mt-3 p-2 rounded"> <div class="d-flex flex-row col-12"><img class="rounded" src="Imagenes/Productos/' + data.data.imagen + '" width="40">  <div class="ml-2"><span class="font-weight-bold d-block">' + data.data.nombre + '</span> </div> </div> <div class="d-flex flex-row align-items-center"> <span id="precio_' + id + '" class="d-block ml-5 font-weight-bold texto_carrito">' + convertir_dinero(data.data.precio) + '</span> <a onclick="sacar_item_carro(' + id + ',this,' + (precios.length - 1) + ')" class="btn btn-danger ml-5"> <i class="fa fa-trash-o ml-3 text-black-50"></i> </a>  </div> </div>';
                            document.getElementById('productos_carro_compra').innerHTML += texto;
                            precio = precio + Number.parseInt(data.data.precio);
                            document.getElementById('total').innerText = convertir_dinero(precio);
                            var cantidad = document.getElementById('cantidad_productos_carrito');
                            cantidad.innerHTML = Number.parseInt(cantidad.innerHTML) + 1;
                        }
                    })
                    .catch((error) => {
                        error_mensaje(error);
                    });

            } catch (error) {
                error_mensaje(error);

            }
        }

        function sacar_item_carro(id, elemento, borrar) {
            try {
                elemento.parentElement.parentElement.remove();
                var cantidad = document.getElementById('cantidad_productos_carrito');
                cantidad.innerHTML = Number.parseInt(cantidad.innerHTML) - 1;
                console.log(borrar);
                precio = Number.parseInt(precio) - Number.parseInt(precios[borrar]);
                delete precios[borrar];
                document.getElementById('total').innerText = convertir_dinero(precio);
            } catch (error) {
                error_mensaje(error);
            }
        }
    <?php
    } ?>

    function navegar(id, elemento) {
        try {
            var active = document.getElementsByClassName('active')[0];
            if (active != undefined) {
                active.classList.remove('active');
            }
            var lista = elemento.classList;
            if (lista != undefined) {
                lista.add('active');
            }
            fetch(id + ".php?" + filtro)
                .then((response) =>
                    response.text())
                .then((html) => {
                    document.getElementById("contenido").innerHTML = html;
                    load_js(id + '.js');
                    load_js('nosotros/newsletter.js');
                    filtro = '';
                })
                .catch((error) => {
                    error_mensaje(error);
                });

        } catch (error) {
            error_mensaje(error);
        }
    }

    function error_mensaje(error) {
        try {
            appendAlert('Ocurrio un error', 'danger');
            console.log(error);
        } catch (error) {

        }
    }

    function load_js(id) {
        try {
            fetch('<?php echo Config::$ruta;?>' + id).then(function(response) {
                if (!response.ok) {
                    return false;
                }
                return response.blob();
            }).then(function(myBlob) {
                var objectURL = URL.createObjectURL(myBlob);
                var sc = document.createElement("script");
                sc.setAttribute("src", objectURL);
                sc.setAttribute("type", "text/javascript");
                document.head.appendChild(sc);
            })
        } catch (error) {
            error_mensaje(error);
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>