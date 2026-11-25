//Immediately-Invoked Function Expression (IIFE)
(function () {
    // Este es el id de la ventana modal
    const infoProduct = $("#infoProduct");

    // Evento click en todos los enlaces del producto con clase `open-info-product`
    $("a.open-info-product").click(function (event) {
        // Nos prevenimos de que el enlace no recargue la página
        event.preventDefault();

        // Hemos añadido el atributo `data-id` para poder saber que producto pedir 
        const id = $(this).attr('data-id');
        // Esta es la ruta a la api
        const href = `/api/productos/${id}`;
        fetch(href)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Cuando devuelve los datos, `data` tiene los datos en json y ya puedo
                // sustituir la plantilla con los datos correctos
                $(infoProduct).find("#productName").text(data.name);
                $(infoProduct).find("#productPrice").text(data.price);
                $(infoProduct).find("#productImage").attr("src", "/img/" + data.photo);

                // Mostrar la ventana
                infoProduct.modal('show');
            })
            .catch(error => {
                console.error('Error al cargar el producto:', error);
            });
    });
    // La ventana tiene un botón con la clase `closeInfoProduct` que haremos que esconda la modal
    $(".closeInfoProduct").click(function (e) {
        infoProduct.modal('hide');
    });
})();
