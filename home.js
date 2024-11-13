function filtrar(className) {
  try {
    var encontrado = false;
    className = " " + className + " ";
    var no_encontrado = document.getElementById("no_encontrado");
    var e = document.getElementById("productos_section").firstChild;
    while (e != null) {
      if (e.nodeType == 1) {
        if ((" " + e.className + " ").indexOf(className) > -1) {
          e.style.display = "block";
          encontrado = true;
        } else {
          e.style.display = "none";
        }
      }

      e = e.nextSibling;
    }
    no_encontrado.classList.add("d-none");
    if (encontrado == false) {
      no_encontrado.classList.remove("d-none");
    }
  } catch (error) {
    error_mensaje(error);
  }
}

function check_precios() {
  try {
    var montos = document.getElementsByClassName("monto");
    for (var i = 0; i < montos.length; i++) {
      montos[i].innerHTML = convertir_dinero(montos[i].innerHTML);
    }
  } catch (error) {
    error_mensaje(error);
  }
}

check_precios();
