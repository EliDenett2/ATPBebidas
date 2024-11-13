function cargar_mas(limit) {
  try {
    fetch("Productos/producto_offset.php?limit=" + limit)
      .then((response) => response.text())
      .then((html) => {
        document.getElementById("cargar_productos").innerHTML = html;
        check_precios();
      })
      .catch((err) => error_mensaje(err));
  } catch (error) {
    error_mensaje(error);
  }
}

cargar_mas(0);


function check_precios() {
  try {
    var montos = document.getElementsByClassName("monto");
    for (var i = 0; i < montos.length; i++) {
      montos[i].innerHTML = convertir_dinero(montos[i].innerHTML);
      montos[i].classList.remove('monto');
    }
  } catch (error) {
    error_mensaje(error);
  }
}


