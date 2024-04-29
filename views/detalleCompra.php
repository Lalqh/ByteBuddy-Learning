<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
ead>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Productos en el Carrito</h1>
        <div class="row" id="carritoProductos">
            <!-- Productos agregados al carrito -->
        </div>
        <button id="comprarBtn" class="btn btn-primary mt-3">Comprar</button>
    </div>

    <script>
        // Cargar productos del localStorage al cargar la página
        window.addEventListener('DOMContentLoaded', () => {
            const carritoProductos = document.getElementById('carritoProductos');
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

            if (carrito.length === 0) {
                carritoProductos.innerHTML = '<p class="col-12">No hay productos en el carrito.</p>';
            } else {
                carrito.forEach(producto => {
                    const productoHTML = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="${producto.imagen}" class="card-img-top" alt="${producto.nombre}">
                                <div class="card-body">
                                    <h5 class="card-title">${producto.nombre}</h5>
                                    <p class="card-text">${producto.descripcion}</p>
                                    <p class="card-text">Precio: $${producto.precio}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    carritoProductos.innerHTML += productoHTML;
                });
            }
        });

        // Función para realizar la compra (se cambiara a la logica de compra de cursos.)
        document.getElementById('comprarBtn').addEventListener('click', () => {
          
            alert('¡Compra realizada con éxito!');
           
            localStorage.removeItem('carrito');
            
            window.location.href = '../index.php';
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>