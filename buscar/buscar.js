function buscar() {
    try {
        var cantidad = 0;
        const input = document.getElementById('filter').value.toUpperCase();
        const cardContainer = document.getElementById('productos_section');
        const cards = cardContainer.getElementsByClassName('card');

        for(let i = 0; i < cards.length; i++) {
            let title = cards[i].querySelector("h4.card-title");

            if(title.innerText.toUpperCase().indexOf(input) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
                cantidad++;
            }

        }
        if(cards.length == cantidad){
          document.getElementById('no_encontrado').classList.remove('d-none');
        } else {
            document.getElementById('no_encontrado').classList.add('d-none');
        }
    } catch (error) {
        error_mensaje(error);
    }
}

buscar();