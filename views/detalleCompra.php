<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="../styles/detalleCompra.css" />

</head>

<body>
     <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d1b31;">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="../assets/images/Logo ByteBuddy Learning.png" alt="Logo ByteBuddy Learning" id="imgLogo" class="">
        </a>
        <span class="h5 mt-3 text-white">Bienvenido</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a id="sesion" class="nav-link text-white" href="#"><i
                            class="fa-solid fa-arrow-right-from-bracket px-1"></i>Cerrar
                        Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
    <br/><br/>
          <footer>
        <div class="container-fluid">
          <div class="row p-5  text-white"><!--Contenedor de footer-->
            <div class="col-xs-12 col-md6 col-lg-3"><!--tam: movil-tablets-laptos,Pc´s-->
              <p class="h3">ByteBuddy Learning</p>
              <p class="text-secondary text-white">Guadalajara,Jal</p>
            </div>
            <div class="col-xs-12 col-md6 col-lg-3">
              <p class="h5 mb-3">Redes sociales</p>
              <div class="mb-2">
                <a href="#" class="text-decoration-none text-secondary"> <i
                    class="fa-brands fa-facebook p-1"></i>Facebook</a>
              </div>
              <div class="mb-2">
                <a href="#" class="text-decoration-none text-secondary"><i
                    class="fa-brands fa-twitter p-1"></i>Twitter</a>
              </div>
              <div class="mb-2">
                <a href="#" class="text-decoration-none text-secondary"><i
                    class="fa-brands fa-instagram p-1"></i>Instagram</a>
              </div>
            </div>
            <div class="col-xs-12 col-md6 col-lg-3">
              <p class="h5 mb-3">Links</p>
              <div class="mb-2">
                <a href="#" class="text-decoration-none text-secondary">Terminos y condiciones</a>
              </div>
              <div class="mb-2">
                <a href="#" class="text-decoration-none text-secondary">Politicas de privacidad</a>
              </div>
            </div>
            <div class="col-xs-12 col-md6 col-lg-3">
              <p class="h5 mb-3">Elaborado por:</p>
              <div class="mb-2">
                <p class="text-secondary">Equipo dinamita</p>
              </div>
            </div>
          </div>
        </div>
      </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>